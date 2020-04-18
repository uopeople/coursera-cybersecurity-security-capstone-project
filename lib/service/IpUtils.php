<?php


namespace lib\service;


class IpUtils
{

    /**
     * Returns the user's ip address. Returns null if the ip could not be detected.
     */
    public static function getIp(): ?string
    {
        // TODO how is our runtime environment? do we get the remote address via a proxy header?
        //  See https://www.codexworld.com/how-to/get-user-ip-address-php/
        //  But note that if the proxy does NOT set this header, and instead relays it from the client (which it shouldn't),
        //  then this would be a security risk, since the client could *very easily* fake it's IP.
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        }
        if ($ip && filter_var($ip, FILTER_VALIDATE_IP)) {
            Logger::getInstance()->logMessage(Logger::LEVEL_DEBUG, 'remote IP: ' . $ip);
            return $ip;
        }
        Logger::getInstance()->logMessage(Logger::LEVEL_WARN, 'could not detect remote IP');
        return null;
    }
}