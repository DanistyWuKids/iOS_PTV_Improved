//
//  DirectionsViewController.swift
//  Oh_My-Transport
//
//  Created by OriWuKids on 19/5/19.
//  Copyright © 2019 wgon0001. All rights reserved.
//

import UIKit
import MapKit
import CoreLocation
import CoreData

struct multiStopsDepartures: Codable{
    var stopId: Int?
    var stopName: String?
    var nextDepartures: [Departure]?
    private enum CodingKeys: String, CodingKey{
        case stopId
        case stopName
        case nextDepartures
    }
    init(stopId: Int?, stopName: String?, nextDepartures: [Departure]?) {
        self.stopId = stopId
        self.stopName = stopName
        self.nextDepartures = nextDepartures
    }
}

class BackupDirectionsViewController: UIViewController, UITableViewDelegate, UITableViewDataSource, MKMapViewDelegate, CLLocationManagerDelegate {
    
    // MARK: - CoreData Properties
    var managedContext: NSManagedObjectContext!
    var stops: FavStop?
    
    let locationManager = CLLocationManager()
    var nslock = NSLock()
    var currentLocation:CLLocation!
    
    var directions: [Run] = []
    var disruptiondata: [Disruption] = []
    var allstopsdata: [stopOnRoute] = []    // Stops are sorted by distance to user
    var selectedId: [Int] = []              // Using for passing segue to next page
    var userPosition = CLLocation(latitude: 0.00, longitude: 0.00)
    
    var routeId: Int = 12753                // Testing value, rely on last page segue passing value to this page
    var routeType: Int = 2                  // Testing value, rely on last page segue passing value to this page
    var routeName: String?
    var runs: [Run] = []
    var nextDepartures: [multiStopsDepartures] = []
    
    var routeDirections: [DirectionWithDescription] = []
    
    @IBOutlet weak var directionsTableView: UITableView!
    @IBOutlet weak var routeMapView: MKMapView!
    @IBOutlet weak var saveButton: UIBarButtonItem!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        directionsTableView.delegate = self
        directionsTableView.dataSource = self
        
        // Load the MapView
        if (CLLocationManager.authorizationStatus() == CLAuthorizationStatus.authorizedWhenInUse ||
            CLLocationManager.authorizationStatus() == CLAuthorizationStatus.authorizedAlways){
            guard locationManager.location != nil else {
                return
            }
        }
        locationManager.delegate = self
        locationManager.desiredAccuracy = kCLLocationAccuracyNearestTenMeters
        self.locationManager.startUpdatingLocation()
        
        _ = URLSession.shared.dataTask(with: URL(string: showRouteInfo(routeId: routeId))!){ (data, response, error) in
            if error != nil{
                print("Route running data fetch failed")
                return
            }
            do {
                let routeData = try JSONDecoder().decode(RouteResponse.self, from: data!)
                if routeData.route?.routeNumber != nil{
                    self.routeName = routeData.route?.routeNumber
                } else{
                    self.routeName = routeData.route?.routeName
                }
                DispatchQueue.main.async {
                    if self.routeType == 0 {
                        self.navigationItem.title = "\(self.routeName!) Line"
                    } else if self.routeType == 1{
                        self.navigationItem.title = "Tram \(self.routeName!)"
                    } else if self.routeType == 2 || self.routeType == 4{
                        self.navigationItem.title = "Bus \(self.routeName!)"
                    } else {
                        self.navigationItem.title = "Route: \(self.routeName!)"
                    }
                    self.saveButton.isEnabled = true
                }
            } catch {
                print("Error:\(error)")
            }
            }.resume()
        
        // Fetching all Stops on MapView
        _ = URLSession.shared.dataTask(with: URL(string: showRoutesStop(routeId: routeId, routeType: routeType))!){(data, response, error) in
            if error != nil{
                print("Stops fetch failed")
                return
            }
            do{
                let stopsdata = try JSONDecoder().decode(StopsResponseByRouteId.self, from: data!)
                if stopsdata.stops != nil{
                    self.allstopsdata = stopsdata.stops!            // All stops data are in.
                    var distance:[Double] = []
                    let userLocation = CLLocation(latitude: (self.locationManager.location?.coordinate.latitude) ?? 0.0, longitude: (self.locationManager.location?.coordinate.longitude) ?? 0.0)
                    for each in self.allstopsdata{
                        let latitude:Double = each.stopLatitude ?? 0.0
                        let longitude:Double = each.stopLongtitude ?? 0.0
                        let stopPatterns = MKPointAnnotation()
                        stopPatterns.title = each.stopName
                        stopPatterns.subtitle = each.stopSuburb
                        stopPatterns.coordinate = CLLocationCoordinate2D(latitude: latitude, longitude: longitude)
                        self.routeMapView.addAnnotation(stopPatterns)
                        distance.append(userLocation.distance(from: CLLocation(latitude: each.stopLatitude!, longitude: each.stopLongtitude!)))
                    }
                    for sequence in 0 ..< self.allstopsdata.count{  // Bubble sorting for stops by stopDistance
                        for eachStops in 0 ..< self.allstopsdata.count-1-sequence{
                            if distance[eachStops] > distance[eachStops+1]{
                                let temp = self.allstopsdata[eachStops+1]
                                let tempDistance = distance[eachStops+1]
                                self.allstopsdata[eachStops+1] = self.allstopsdata[eachStops]
                                distance[eachStops+1] = distance[eachStops]
                                self.allstopsdata[eachStops] = temp
                                distance[eachStops] = tempDistance
                            }
                        }
                    }
                    
                    // Checking Directions
                    _ = URLSession.shared.dataTask(with: URL(string: showDirectionsOnRoute(routeId: self.routeId))!){ (data, response, error) in
                        if error != nil {
                            print("Route directions fetch failed")
                            return
                        }
                        do{
                            let directionData = try JSONDecoder().decode(DirectionsResponse.self, from: data!)
                            guard (directionData.directions?.count)! > 0 else{
                                return
                            }
                            self.routeDirections = directionData.directions!
                            for eachDirection in directionData.directions!{     // Looping all directions
                                for eachStops in 0 ..< 5{                       // fetch stopId
                                    let url = URL(string: showRouteDepartureOnStop(routeType: self.routeType, stopId: self.allstopsdata[eachStops].stopId!, routeId: self.routeId, directionId: eachDirection.directionId!))
                                    _ = URLSession.shared.dataTask(with: url!){ (data, response, error) in
                                        if error != nil{
                                            print("Stops fetch failed")
                                            return
                                        }
                                        do{
                                            let departureData = try JSONDecoder().decode(DeparturesResponse.self, from: data!)
                                            self.nextDepartures.append(multiStopsDepartures.init(stopId: self.allstopsdata[eachStops].stopId!, stopName: self.allstopsdata[eachStops].stopName, nextDepartures: departureData.departures))
                                        } catch {
                                            print("Error:\(error)")
                                        }
                                        }.resume()
                                }
                            }
                            DispatchQueue.main.async {
                                self.directionsTableView.reloadData()
                            }
                        }
                        catch{
                            print("Error:\(error)")
                        }
                        }.resume()
                    
                }
            } catch{
                print("Error:\(error)")
            }
            }.resume()
        
        // Checking if having any disruptions affect this route
        _ = URLSession.shared.dataTask(with: URL(string: disruptionByRoute(routeId: routeId))!){ (data, response, error) in
            if error != nil {
                print("Route directions fetch failed")
                return
            }
            do{
                let disruptionData = try JSONDecoder().decode(DisruptionsResponse.self, from: data!)
                if (self.routeType == 0 && (disruptionData.disruptions?.metroTrain?.count)!>0) {
                    self.disruptiondata += (disruptionData.disruptions?.metroTrain)!
                } else if (self.routeType == 1 && (disruptionData.disruptions?.metroTram?.count)!>0){
                    self.disruptiondata += (disruptionData.disruptions?.metroTram)!
                } else if (self.routeType == 2 && (disruptionData.disruptions?.metroBus?.count)!>0 && (disruptionData.disruptions?.regionalBus?.count)!>0 && (disruptionData.disruptions?.skybus?.count)!>0){
                    self.disruptiondata += (disruptionData.disruptions?.metroBus)!
                    self.disruptiondata += (disruptionData.disruptions?.regionalBus)!
                    self.disruptiondata += (disruptionData.disruptions?.skybus)!
                } else if (self.routeType == 3 && (disruptionData.disruptions?.vlineCoach?.count)!>0 && (disruptionData.disruptions?.vlineTrain?.count)!>0) {
                    self.disruptiondata += (disruptionData.disruptions?.vlineCoach)!
                    self.disruptiondata += (disruptionData.disruptions?.vlineTrain)!
                } else if (self.routeType == 4 && (disruptionData.disruptions?.nightbus?.count)! > 0){
                    self.disruptiondata = (disruptionData.disruptions?.nightbus)!
                }
                DispatchQueue.main.async {
                    self.directionsTableView.reloadData()
                }
            }
            catch{
                print("Error:\(error)")
            }
            }.resume()
    }
    
    // MARK: - Navigation
    
    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        if segue.identifier == "showNextService"{
            let page2:StopPageTableViewController = segue.destination as! StopPageTableViewController
            page2.routeType = routeType
            page2.routeId = routeId
            page2.stopId = allstopsdata[selectedId[(directionsTableView.indexPathForSelectedRow?.row)!]].stopId!
        }
        if segue.identifier == "showServiceDisruptions"{
            let page2:DisruptionsTableViewController = segue.destination as! DisruptionsTableViewController
            page2.url = URL(string: disruptionByRoute(routeId: routeId))
        }
    }
    
    // MARK: - Table view data source
    
    func numberOfSections(in tableView: UITableView) -> Int {
        return 2
    }
    
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if section == 0 {
            if disruptiondata.count > 0 {
                return 1
            }
            return 0
        }
        return routeDirections.count
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        if indexPath.section == 0 {
            let cell = tableView.dequeueReusableCell(withIdentifier: "disruption", for: indexPath) as! directionDisruptionsTableViewCell
            if disruptiondata.count > 1 {
                cell.disruptionTitleLabel.text = "\(disruptiondata.count) disruptions may affect your trip"
            } else {
                cell.disruptionTitleLabel.text = "\(disruptiondata.count) disruption may affect your trip"
            }
            cell.disruptionSubtitleLabel.text = "Tap to see details"
            self.navigationItem.rightBarButtonItem?.isEnabled = true
            return cell
        }
        if indexPath.section == 1{
            let cell = tableView.dequeueReusableCell(withIdentifier: "directions", for: indexPath) as! DirectionTableViewCell
            cell.directionNameLabel.text = routeDirections[indexPath.row].directionName
            let cellDirectionId = routeDirections[indexPath.row].directionId
            cell.departure0Time.text = ""
            cell.departure1Time.text = ""
            cell.departure2Time.text = ""
            cell.departure0Countdown.text = ""
            cell.departure1Countdown.text = ""
            cell.departure2Countdown.text = ""
            print("Require direction:\(cellDirectionId)")
            for each in nextDepartures{
                print("Service qty: \(each.nextDepartures?.count), currentDirection:\(each.nextDepartures?[0].directionId)")
                if (each.nextDepartures?.count)! > 0 && each.nextDepartures?[0].directionId == cellDirectionId {
                    cell.nearStopLabel.text = each.stopName
                    if each.nextDepartures?.count ?? 0 > 2{
                        cell.departure2Time.text = Iso8601toString(iso8601Date: each.nextDepartures![2].estimatedDepartureUTC ?? (each.nextDepartures![2].scheduledDepartureUTC)!, withTime: true, withDate: false)
                        cell.departure2Countdown.text = ""
                    }
                    if each.nextDepartures?.count ?? 0 > 1{
                        cell.departure1Time.text = Iso8601toString(iso8601Date: each.nextDepartures![1].estimatedDepartureUTC ?? (each.nextDepartures![1].scheduledDepartureUTC)!, withTime: true, withDate: false)
                        cell.departure1Countdown.text = ""
                    }
                    if each.nextDepartures?.count ?? 0 > 0{
                        cell.departure0Time.text = Iso8601toString(iso8601Date: each.nextDepartures![0].estimatedDepartureUTC ?? (each.nextDepartures![0].scheduledDepartureUTC)!, withTime: true, withDate: false)
                        cell.departure0Countdown.text = ""
                    } else {
                        cell.departure0Time.text = "🤦‍♂️"
                        cell.departure1Time.text = "No Service available"
                    }
                }
            }
            
            //            cell.departure0Time.text = Iso8601toString(iso8601Date: departures?[count].estimatedDepartureUTC ?? (departures?[count].scheduledDepartureUTC)!, withTime: true, withDate: false)
            //            cell.departure0Countdown.text = Iso8601Countdown(iso8601Date: departures?[count].estimatedDepartureUTC ?? (departures?[count].scheduledDepartureUTC)!, status: true)
            
            //
            //            var availableStop: [stopOnRoute] = []
            //            var loopTimes = 5
            //            if allstopsdata.count < loopTimes{
            //                loopTimes = allstopsdata.count
            //            }
            //            for each in 0 ..< loopTimes{
            //                var flag = false
            //                let url = URL(string: showRouteDepartureOnStop(routeType: routeType, stopId: allstopsdata[each].stopId!, routeId: routeId, directionId: routeDirections[indexPath.row].directionId!))
            //                _ = URLSession.shared.dataTask(with: url!){ (data, response, error) in
            //                    if error != nil{
            //                        print("Stops fetch failed")
            //                        return
            //                    }
            //                    do{
            //                        let departureDictonary: NSDictionary = try JSONSerialization.jsonObject(with: data!, options: .mutableContainers) as! NSDictionary
            //                        let directions = departureDictonary.value(forKey: "directions") as! NSDictionary
            //                        if directions.count != 0{
            //                            flag = true
            //                            availableStop.append(self.allstopsdata[each])
            //                            self.selectedId.append(-1)
            //                            if (self.selectedId[indexPath.row] == -1){
            //                                self.selectedId[indexPath.row] = each
            //                            }
            //                            DispatchQueue.main.async {
            //                                cell.nearStopLabel.text = availableStop[0].stopName
            //                            }
            //
            //                        }
            //                        let departureData = try JSONDecoder().decode(DeparturesResponse.self, from: data!)
            //                        let departures = departureData.departures
            //                        var count = 0
            //                        for _ in departures!{
            //                            let differences = Calendar.current.dateComponents([.minute], from: NSDate.init(timeIntervalSinceNow: 0) as Date, to: Iso8601toDate(iso8601Date: (departures![count].estimatedDepartureUTC ?? (departures![count].scheduledDepartureUTC ?? nil)!)))
            //                            print("Time Difference:\(differences.minute)")
            //                            if differences.minute! >= -1{
            //                                break
            //                            }
            //                            count += 1
            //                        }
            //                        if flag == true && departures?.count != 0 && count < (departures?.count)!{
            //                            DispatchQueue.main.async {
            //                                cell.departure0Time.text = ""
            //                                cell.departure1Time.text = ""
            //                                cell.departure2Time.text = ""
            //                                cell.departure0Countdown.text = ""
            //                                cell.departure1Countdown.text = ""
            //                                cell.departure2Countdown.text = ""
            //                                if (count < departures!.count && departures?[count].scheduledDepartureUTC != nil) {
            //                                    cell.departure0Time.text = Iso8601toString(iso8601Date: departures?[count].estimatedDepartureUTC ?? (departures?[count].scheduledDepartureUTC)!, withTime: true, withDate: false)
            //                                    cell.departure0Countdown.text = Iso8601Countdown(iso8601Date: departures?[count].estimatedDepartureUTC ?? (departures?[count].scheduledDepartureUTC)!, status: true)
            //                                }
            //                                if (count+1 < departures!.count && departures?[count+1].scheduledDepartureUTC != nil) {
            //                                    cell.departure1Time.text = Iso8601toString(iso8601Date: departures?[count+1].estimatedDepartureUTC ?? (departures?[count+1].scheduledDepartureUTC)!, withTime: true, withDate: false)
            //                                    cell.departure1Countdown.text = Iso8601Countdown(iso8601Date: departures?[count+1].estimatedDepartureUTC ?? (departures?[count+1].scheduledDepartureUTC)!, status: true)
            //                                }
            //                                if (count+2 < departures!.count && departures?[2].scheduledDepartureUTC != nil) {
            //                                    cell.departure2Time.text = Iso8601toString(iso8601Date: departures?[count+2].estimatedDepartureUTC ?? (departures?[count+2].scheduledDepartureUTC)!, withTime: true, withDate: false)
            //                                    cell.departure2Countdown.text = Iso8601Countdown(iso8601Date: departures?[count+2].estimatedDepartureUTC ?? (departures?[count+2].scheduledDepartureUTC)!, status: true)
            //                                }
            //                            }
            //                        }else{
            //                            DispatchQueue.main.async {
            //                                cell.departure0Time.text = "🤦‍♂️"
            //                                cell.departure1Time.text = "No Service available"
            //                                cell.departure2Time.text = ""
            //                                cell.departure0Countdown.text = ""
            //                                cell.departure1Countdown.text = ""
            //                                cell.departure2Countdown.text = ""
            //                            }
            //                        }
            //                    }catch{
            //                        print("Error:\(error)")
            //                    }
            //                }.resume()
            //                if flag == true{
            //                    break
            //                }
            //            }
            return cell
        }
        let cell = tableView.dequeueReusableCell(withIdentifier: "nothing", for: indexPath)
        return cell
    }
    
    override func viewWillAppear(_ animated: Bool) {
        locationManager.startUpdatingLocation()
    }
    override func viewWillDisappear(_ animated: Bool) {
        super.viewWillDisappear(animated)
        locationManager.stopUpdatingLocation()
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    @IBAction func saveRoute(_ sender: Any) {
        let route = FavRoute(context: managedContext)
        route.routeId = Int32(routeId)
        route.routeType = Int32(routeType)
        do {
            try managedContext?.save()
            let _ = navigationController?.popViewController(animated: true)
            //            let _ = navigationController?.popToRootViewController(animated: true)
        } catch {
            print("Error to save route")
        }
    }
    
    // MARK: - Functions for MapView
    func locationManager(_ manager: CLLocationManager, didUpdateLocations locations: [CLLocation]) {
        self.locationManager.stopUpdatingLocation()
        let currentLocationSpan:MKCoordinateSpan = MKCoordinateSpan(latitudeDelta: 0.02, longitudeDelta: 0.02)
        // 使用线路中间车站
        let currentLatitude = locations[0].coordinate.latitude
        let currentLongtitude = locations[0].coordinate.longitude
        let region = MKCoordinateRegion(center: CLLocationCoordinate2D(latitude: currentLatitude, longitude: currentLongtitude), span: currentLocationSpan)
        userPosition = CLLocation(latitude: currentLatitude, longitude: currentLongtitude)
        self.routeMapView.setRegion(region, animated: true)
        print("Currnet Location = \(currentLatitude),\(currentLongtitude)")
    }
    
    func locationManager(_ manager: CLLocationManager, didFailWithError error: Error) {
        print("Unable to access your current location")
    }
}