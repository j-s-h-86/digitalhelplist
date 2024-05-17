<?php
require_once ('Models/UserDatabase.php');
require_once ('Models/HelpRequest.php');
require_once ('Models/Students.php');
require_once ('Models/Teachers.php');
require_once ('Models/Courses.php');



class DBContext
{
    private $pdo;
    private $usersDatabase;

    function getUsersDatabase()
    {
        return $this->usersDatabase;
    }

    function __construct()
    {
        $host = $_ENV["host"];
        $db = $_ENV["db"];
        $user = $_ENV["user"];
        $pass = $_ENV["pass"];
        $dsn = "mysql:host=$host;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->usersDatabase = new UserDatabase($this->pdo);
        $this->usersDatabase->setupUsers();
        $this->usersDatabase->seedUsers();
        $this->initIfNotInitialized();
        $this->seedIfNotSeeded();
    }

    function addCourses($courseName)
    {
        $prep = $this->pdo->prepare('INSERT INTO courses (CourseName) VALUES(:CourseName)');
        $prep->execute(["CourseName" => $courseName]);

        return $this->pdo->lastInsertId();
    }

    function getCourseByName($courseName)
    {
        $prep = $this->pdo->prepare('SELECT * FROM courses where CourseName=:CourseName');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Courses');
        $prep->execute(['CourseName' => $courseName]);
        return $prep->fetch();
    }

    function addStudent($StudentName, $Email, $CourseID, $UserID)
    {
        $prep = $this->pdo->prepare('INSERT INTO students (Studentname, Email, CourseID, UserID) VALUES(:Studentname,:Email, :CourseID, :UserID)');
        $prep->execute(["Studentname" => $StudentName, "Email" => $Email, "CourseID" => $CourseID, "UserID" => $UserID]);
        return $this->pdo->lastInsertId();
    }

    function getStudentByName($StudentName)
    {
        $prep = $this->pdo->prepare('SELECT * FROM students where Studentname=:Studentname');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Students');
        $prep->execute(['Studentname' => $StudentName]);
        return $prep->fetch();
    }

    function addTeacher($name, $Email, $CourseID, $UserID)
    {
        $prep = $this->pdo->prepare('INSERT INTO teachers (name, Email, CourseID, UserID) VALUES(:name,:Email, :CourseID, :UserID)');
        $prep->execute(["name" => $name, "Email" => $Email, "CourseID" => $CourseID, "UserID" => $UserID]);
        return $this->pdo->lastInsertId();
    }

    function getTeacherByName($name)
    {
        $prep = $this->pdo->prepare('SELECT * FROM teachers where name=:name');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Teachers');
        $prep->execute(['name' => $name]);
        return $prep->fetch();
    }

    function getAllHelpRequest()
    {
        return $this->pdo->query('SELECT * FROM helplist ORDER BY Id')->fetchAll(PDO::FETCH_CLASS, 'HelpRequest');
    }

    function getPlaceInQueue()
    {
        $currentMaxId = $this->pdo->query('SELECT MAX(Id) FROM helplist')->fetch(PDO::FETCH_COLUMN, 0);
        return $this->pdo->query('SELECT COUNT(*) FROM helplist WHERE Id <= ' . $currentMaxId . ' and Active = 1')->fetch(PDO::FETCH_COLUMN, 0);
    }

    function getHelpRequest($Email)
    {
        $query = 'SELECT * FROM helplist WHERE Email="' . $Email . '" AND Active=1';
        return $this->pdo->query($query)->fetchAll(PDO::FETCH_CLASS, 'HelpRequest');
    }

    function seedIfNotSeeded()
    {
        static $seeded = false;
        if ($seeded)
            return;
        $this->createIfNotExisting("Kriss Trädkoja", "kriss@kriss.se", "Teams", 1, "Öronfluss", 4);
        $this->createIfNotExisting("Pellan G-unit", "pellan@pellan.se", "Rum2", 2, "Valideringsbekymmer", 2);
        $this->createIfNotExisting("Johan-Toan", "johan@johan.se", "Acapulco", 2, "Dålig stämning", 3);

        $seeded = true;
    }

    function getExistingRequests($Email): int
    {
        $query = 'SELECT * FROM helplist WHERE Email="' . $Email . '"';
        return $this->pdo->query($query)->rowCount();
    }

    function createIfNotExisting($StudentName, $Email, $Location, $CourseID, $Question, $UserID)
    {
        $existing = $this->getExistingRequests($Email);
        if ($existing > 0) {
            return;
        }
        ;
        return $this->addHelpRequest($StudentName, $Email, $Location, $CourseID, $Question, 1, $UserID);

    }


    function addHelpRequest($StudentName, $Email, $Location, $CourseID, $Question, $Active, $UserID)
    {
        $prep = $this->pdo->prepare('INSERT INTO helplist (StudentName, Email, Location, CourseID, Question, Active, UserID) 
        VALUES(:StudentName, :Email, :Location, :CourseID, :Question, :Active, :UserID )');
        $prep->execute(["StudentName" => $StudentName, "Email" => $Email, "Location" => $Location, "CourseID" => $CourseID, "Question" => $Question, "Active" => $Active, "UserID" => $UserID]);
        return $this->pdo->lastInsertId();
    }


    function updateHelpRequest($Id)
    {
        $prep = $this->pdo->prepare("UPDATE helplist SET `Active` = 0 WHERE Id=:Id");
        $prep->execute(["Id" => $Id]);
        return "Updaterad";
    }

    function initIfNotInitialized()
    {

        static $initialized = false;
        if ($initialized)
            return;

        $sql = "CREATE TABLE IF NOT EXISTS `courses` (
                `Id` INT AUTO_INCREMENT NOT NULL,
                `CourseName`varchar(200) NOT NULL,
                PRIMARY KEY (`Id`)
            )";

        $this->pdo->exec($sql);
        if (!$this->getCourseByName("Frontend")) {
            $this->addCourses("Frontend");
        }
        if (!$this->getCourseByName("Backend")) {
            $this->addCourses("Backend");
        }

        $sql = "CREATE TABLE IF NOT EXISTS `students` (
                `Id`INT AUTO_INCREMENT NOT NULL,
                `Studentname`varchar(200) NOT NULL,
                `Email`varchar(200) NOT NULL,
                `CourseID` INT NOT NULL,
                `UserID` int(10) unsigned NOT NULL,
                PRIMARY KEY (`Id`),
            FOREIGN KEY (CourseID) REFERENCES courses(Id),
            FOREIGN KEY (UserID) REFERENCES users(id)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";

        $this->pdo->exec($sql);
        if (!$this->getStudentByName("Kriss Stockhaus")) {
            $this->addStudent("Kriss Stockhaus", "kriss@kriss.se", 1, 4);
        }
        if (!$this->getStudentByName("Pellan G")) {
            $this->addStudent("Pellan G", "pellan@pellan.se", 2, 2);
        }
        if (!$this->getStudentByName("Johan H")) {
            $this->addStudent("Johan H", "johan@johan.se", 2, 3);
        }

        $sql = "CREATE TABLE IF NOT EXISTS `teachers` (
            `Id`INT AUTO_INCREMENT NOT NULL,
            `Name` varchar(200) NOT NULL,
            `Email` varchar(200) NOT NULL,
            `CourseID`INT NOT NULL,
            `UserID` INT NOT NULL,
            PRIMARY KEY (`Id`),
            FOREIGN KEY (CourseID) REFERENCES courses(Id),
            FOREIGN KEY (UserID) REFERENCES users(id)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";

        $this->pdo->exec($sql);
        if (!$this->getTeacherByName("Sebastian Tegel")) {
            $this->addTeacher("Sebastian Tegel", "sebbe@tegelrules.se", 1, 6);
        }
        if (!$this->getTeacherByName("Stefan Holmberg")) {
            $this->addTeacher("Stefan Holmberg", "stefan.holmberg@systementor.se", 2, 1);
        }

        $sql = "CREATE TABLE IF NOT EXISTS `helplist` (
            `Id` INT AUTO_INCREMENT NOT NULL,
            `StudentName` varchar(200) NOT NULL,
            `Email` varchar(200) NOT NULL,
            `Location` varchar(200) NOT NULL,
            `CourseID`INT NOT NULL,
            `Question` varchar(400) NOT NULL,
            `UserID` INT NOT NULL,
            `Active` BOOLEAN DEFAULT 1,
            PRIMARY KEY (`Id`),
            FOREIGN KEY (CourseID) REFERENCES courses(Id),
            FOREIGN KEY (UserID) REFERENCES users(id)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";

        $this->pdo->exec($sql);

        $initialized = true;
    }


}


?>