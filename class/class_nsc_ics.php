<?php

class nsc_itp_cookie_saver
{
    private $options;

    public function __construct()
    {
        $this->options = new de_nikelschubert_nsc_ics();
    }

    public function nsc_ics_save_cookies()
    {
        if (get_option("nsc_ics_activate", false) == true) {
            $cookieNamesArray = explode(",", get_option("nsc_ics_cookienames"));
            foreach ($cookieNamesArray as $cookieName) {
                $this->setcookie($cookieName);
            }
        }
    }

    private function setcookie($cookieName)
    {
        $expiryDate = time() + 60 * 60 * 24 * 720;
        $hostname = $this->getCookieHostname();

        if (isset($_COOKIE[$cookieName])) {
            if ($this->options->php_version_good('7.3.0')) {
                setcookie($cookieName, $_COOKIE[$cookieName], array("expires" => $expiryDate, "path" => "/", "domain" => $hostname, "samesite" => "lax"));
            } else {
                setcookie($cookieName, $_COOKIE[$cookieName], $expiryDate, "/; samesite=lax", $hostname);
            }

        }

    }

    private function getCookieHostname()
    {
        if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === "localhost") {
            return "localhost";
        }

        $wordpressUrl = get_bloginfo('url');
        $configured_domain = get_option("nsc_ics_cookiedomain");

        if (!empty($configured_domain)) {
            $domain = parse_url("https://" . $configured_domain, PHP_URL_HOST);
        }

        if (empty($domain)) {
            $domain = parse_url($wordpressUrl, PHP_URL_HOST);
        }

        return $domain;
    }
}
