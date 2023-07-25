<?php
namespace App\Model;
use App\Model\ConnectFactory;
use PDO;
class Product
{
    private PDO $conn;
    public function __construct()
    {
        $this->conn = ConnectFactory::create();
    }
    public function getAll():array
    {
        return $this->conn->query("SELECT * FROM tovary")->fetchAll(PDO::FETCH_ASSOC);
    }
}