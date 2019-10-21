DROP TABLE "Users";
DROP TABLE "Settings";

CREATE TABLE "Users" (
"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"username" TEXT NOT NULL,
"password" TEXT NOT NULL
);

CREATE TABLE "Settings" (
"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"attr_text" TEXT,
"attr_int" INTEGER
);

-- Record sensor triggered time.
CREATE TABLE "Sensors" (
"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"triggered" INTEGER,
"filename" TEXT
);
