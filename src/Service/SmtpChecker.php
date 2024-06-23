<?php

namespace App\Service;

class SmtpChecker
{
    private $host;
    private $port;
    private $timeout;

    // Constructeur de la classe qui initialise les propriétés host, port et timeout
    public function __construct(string $host, int $port, int $timeout = 10)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;
    }

    // Méthode pour vérifier la connexion au serveur SMTP
    public function checkConnection(): bool
    {
        // Tentative d'ouverture d'une connexion à l'hôte et au port spécifiés
        $connection = @fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
        
        // Si la connexion est établie, fermer la connexion et retourner true
        if ($connection) {
            // fclose($connection);
            return true;
        }
        
        // Si la connexion échoue, retourner false
        return false;
    }
}