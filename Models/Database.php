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
        //$this->seedfNotSeeded();
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

    function getHelpRequest($Id, $StudentName, $Email, $Location, $Question, $Active)
    {
        $prep = $this->pdo->prepare('SELECT * FROM helplist where Id=:Id');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'HelpRequest');
        $prep->execute(['Id' => $Id]);
        return $prep->fetch();
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

    function addHelpRequest($StudentName, $Email, $Location, $Question, $Active)
    {
        $prep = $this->pdo->prepare('INSERT INTO helplist (StudentName, Email, Location, Question, Active) VALUES(:StudentName,:Email, :Location, :Question, :Active )');
        $prep->execute(["StudentName" => $StudentName, "Email" => $Email, "Location" => $Location, "Question" => $Question, "Active" => $Active]);
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


        $sql = "CREATE TABLE IF NOT EXISTS `helplist` (
            `Id` INT AUTO_INCREMENT NOT NULL,
            `StudentName` varchar(200) NOT NULL,
            `Email` varchar(200) NOT NULL,
            `Location` varchar(200) NOT NULL,
            `Question` varchar(400) NOT NULL,
            `Active` BOOLEAN DEFAULT 1,
            PRIMARY KEY (`id`)
            ) ";


        //         $sql  ="CREATE TABLE IF NOT EXISTS `Customer` (
//             `Id` int NOT NULL AUTO_INCREMENT,
//             `GivenName` varchar(50) NOT NULL,
//             `Surname` varchar(50) NOT NULL,
//             `Streetaddress` varchar(50) NOT NULL,
//             `City` varchar(50) NOT NULL,
//             `Zipcode` varchar(10) NOT NULL,
//             `Country` varchar(30) NOT NULL,
//             `CountryCode` varchar(2) NOT NULL,
//             `Birthday` datetime NOT NULL,
//             `NationalId` varchar(20) NOT NULL,
//             `TelephoneCountryCode` int NOT NULL,
//             `Telephone` varchar(20) NOT NULL,
//             `EmailAddress` varchar(50) NOT NULL,
//             `OfficeId` INT NOT NULL,
//             PRIMARY KEY (`Id`),
//             FOREIGN KEY (`OfficeId`)
//                 REFERENCES Office(id)
//           ) ";

        $this->pdo->exec($sql);


        //         $this->usersDatabase->setupUsers();
//         $this->usersDatabase->seedUsers();

        //         $initialized = true;
    }


}


?>