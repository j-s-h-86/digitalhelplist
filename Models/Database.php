<?php
require_once ('Models/UserDatabase.php');
require_once ('Models/HelpRequest.php');



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
        $courseNames = ["Frontend", "Backend"];
        $this->addCourses($courseNames);
        $this->seedIfNotSeeded();
    }
    function addCourses($courseNames)
    {
        $prep = $this->pdo->prepare('INSERT INTO courses (CourseName) VALUES(:CourseName)');
        foreach ($courseNames as $courseName) {
            $prep->execute(["CourseName" => $courseName]);
        }
        return $this->pdo->lastInsertId();
    }

    function getAllHelpRequest()
    {

        return $this->pdo->query('SELECT * FROM helplist ORDER BY Id')->fetchAll(PDO::FETCH_CLASS, 'HelpRequest');

    }

    //     function searchCustomers($sortCol, $sortOrder, $q,$categoryId){
    //         if($sortCol == null){
    //             $sortCol = "Id";
    //         }
    //         if($sortOrder == null){
    //             $sortOrder = "asc";
    //         }
    //         $sql = "SELECT * FROM Customer ";
    //         $paramsArray = [];
    //         $addedWhere = false;
    //         if($q != null && strlen($q) > 0){  // Omman angett ett q - WHERE   tef
//                 // select * from product where title like '%tef%' // Stefan  tefan atef
//             if(!$addedWhere){
//                 $sql = $sql . " WHERE ";            
//                 $addedWhere = true;
//             }else{
    //                 $sql = $sql . " AND ";    
//             }
//             $sql = $sql . " ( NationalId like :q";        
//             $sql = $sql . " OR  GivenName like :q";        
//             $sql = $sql . " OR  Surname like :q";        
//             $sql = $sql . " OR  City like :q )";        
//             $paramsArray["q"] = '%' . $q . '%';                
//         }
//         if($categoryId != null && strlen($categoryId) > 0){
//             if(!$addedWhere){
//                 $sql = $sql . " WHERE ";            
//                 $addedWhere = true;
//             }else{
//                 $sql = $sql . " AND ";    
//             }

    //             $sql = $sql . " ( OfficeId = :categoryId )";        
//             $paramsArray["categoryId"] = $categoryId;                
//         }


    //         $sql .= " ORDER BY $sortCol $sortOrder ";    

    //         $prep = $this->pdo->prepare($sql);
//         $prep->setFetchMode(PDO::FETCH_CLASS,'Customer');
//         $prep->execute($paramsArray);


    //         return $prep->fetchAll();        
//     }

    function getHelpRequest($Email)
    {
        $query = 'SELECT * FROM helplist WHERE Email="' . $Email . '" AND Active=1';
        return $this->pdo->query($query)->fetchAll(PDO::FETCH_CLASS, 'HelpRequest');
        // return $prep->fetch();
    }
    //     function getCustomerByNames($GivenName,$Surname){
    //         $prep = $this->pdo->prepare('SELECT * FROM Customer where GivenName=:givenname and Surname=:surname');
    //         $prep->setFetchMode(PDO::FETCH_CLASS,'Customer');
    //         $prep->execute(['givenname'=> $GivenName, 'surname' => $Surname]); 
    //         return  $prep->fetch();
    //     }

    //     function getOfficeByName($title) {
    //         $prep = $this->pdo->prepare('SELECT * FROM Office where name=:title');
//         $prep->setFetchMode(PDO::FETCH_CLASS,'Office');
//         $prep->execute(['title'=> $title]); 
//         return  $prep->fetch();
//     }


    //     function getOffice($id) {
    //         $prep = $this->pdo->prepare('SELECT * FROM Office where id=:id');
//         $prep->setFetchMode(PDO::FETCH_CLASS,'Office');
//         $prep->execute(['id'=> $id]); 
//         return  $prep->fetch();
//     }
    function seedIfNotSeeded()
    {
        static $seeded = false;
        if ($seeded)
            return;
        $this->createIfNotExisting("Kriss Trädkoja", "kriss@kriss.se", "Teams", 1, "Öronfluss");
        $this->createIfNotExisting("Pellan G-unit", "pellan@pellan.se", "Rum2", 2, "Valideringsbekymmer");
        $this->createIfNotExisting("Johan-Toan", "johan@johan.se", "Acapulco", 2, "Dålig stämning");

        $seeded = true;
    }

    function getExistingRequests($Email): int
    {
        $query = 'SELECT * FROM helplist WHERE Email="' . $Email . '"';
        return $this->pdo->query($query)->rowCount();
    }

    function createIfNotExisting($StudentName, $Email, $Location, $Course, $Question)
    {
        $existing = $this->getExistingRequests($Email);
        if ($existing > 0) {
            return;
        }
        ;
        return $this->addHelpRequest($StudentName, $Email, $Location, $Course, $Question, 1);

    }


    function addHelpRequest($StudentName, $Email, $Location, $Course, $Question, $Active)
    {
        $prep = $this->pdo->prepare('INSERT INTO helplist (StudentName, Email, Location, CourseID, Question, Active) 
        VALUES(:StudentName, :Email, :Location, :CourseID, :Question, :Active )');
        $prep->execute(["StudentName" => $StudentName, "Email" => $Email, "Location" => $Location, "CourseID" => $Course, "Question" => $Question, "Active" => $Active]);
        return $this->pdo->lastInsertId();
    }


    function updateHelpRequest($Id)
    {
        $prep = $this->pdo->prepare("UPDATE helplist SET `Active` = 0 WHERE Id=:Id");
        $prep->execute(["Id" => $Id]);
        return "Updaterad";



    }




    //     function addCustomer($givenname, $surname,$Streetaddress, $City, $Zipcode, $Country, $CountryCode, $Birthday, $NationalId, $TelephoneCountryCode, $Telephone, $EmailAddress, $OfficeId){
    //         $prep = $this->pdo->prepare("INSERT INTO Customer
    //                         (GivenName, Surname, Streetaddress, City, Zipcode, Country, CountryCode, Birthday, NationalId, TelephoneCountryCode, Telephone, EmailAddress, OfficeId)
    //                     VALUES(:GivenName, :Surname, :Streetaddress, :City, :Zipcode, :Country, :CountryCode, :Birthday, :NationalId, :TelephoneCountryCode, :Telephone, :EmailAddress, :OfficeId);
    //         ");
    //         $prep->execute(["GivenName"=>$givenname,"Surname"=>$surname,"Streetaddress"=>$Streetaddress,"City"=>$City,
    //             "Zipcode"=>$Zipcode,"Country"=>$Country,
    //             "CountryCode"=>$CountryCode,"Birthday"=>$Birthday,"NationalId"=>$NationalId,"TelephoneCountryCode"=>$TelephoneCountryCode,
    //             "Telephone"=>$Telephone,"EmailAddress"=>$EmailAddress,"OfficeId"=>$OfficeId]);
    //         return $this->pdo->lastInsertId();

    //     }

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

        $sql = "CREATE TABLE IF NOT EXISTS `students` (
                `Id`INT AUTO_INCREMENT NOT NULL,
                `Studentname`varchar(200) NOT NULL,
                `Email`varchar(200) NOT NULL,
                `CourseID` INT NOT NULL,
                PRIMARY KEY (`Id`),
            FOREIGN KEY (CourseID) REFERENCES courses(Id)
            )";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `teachers` (
            `Id`INT AUTO_INCREMENT NOT NULL,
            `Name` varchar(200) NOT NULL,
            `CourseID`INT NOT NULL,
            PRIMARY KEY (`Id`),
            FOREIGN KEY (CourseID) REFERENCES courses(Id)
            ) ";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `helplist` (
            `Id` INT AUTO_INCREMENT NOT NULL,
            `StudentName` varchar(200) NOT NULL,
            `Email` varchar(200) NOT NULL,
            `Location` varchar(200) NOT NULL,
            `CourseID`INT NOT NULL,
            `Question` varchar(400) NOT NULL,
            `Active` BOOLEAN DEFAULT 1,
            PRIMARY KEY (`id`),
            FOREIGN KEY (CourseID) REFERENCES courses(Id) 
            ) ";

        $this->pdo->exec($sql);


        //         $this->usersDatabase->setupUsers();
//         $this->usersDatabase->seedUsers();

        //         $initialized = true;
    }


}


?>