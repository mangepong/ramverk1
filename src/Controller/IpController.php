<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IpController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
     public function indexAction() : object
     {
         $title = "Ip Validator";

         $page = $this->di->get("page");
         // $session = $this->di->get("session");

         // $active = $session->get(self::$key, null);

         $page->add("anax/ipvalidator/index");

         return $page->render([
             "title" => $title,
         ]);
     }


     /**
      * Update current selected style.
      *
      * @return object
      */
     public function indexActionPost() : object
     {
         $response = $this->di->get("response");
         $request = $this->di->get("request");
         $session = $this->di->get("session");
         $ip = $request->getPost("ip");
         $domain = "Not found";

         if(filter_var($ip, FILTER_VALIDATE_IP)) {
             if (gethostbyaddr($ip) != $ip) {
                $domain = gethostbyaddr($ip);
                $res = "`$ip` is a valid IP Adress. Domainname: $domain";
            }
         }
         else {
             $res = "`$ip` is not a valid IP Adress. Domainname: $domain";
         }


         $title = "Ip Validator";

         $page = $this->di->get("page");

         $page->add("anax/ipvalidator/result", [
             "res" => $res,
         ]);

         return $page->render([
             "title" => $title,
         ]);
     }

}
