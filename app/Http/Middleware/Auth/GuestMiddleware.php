<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Middleware\Auth;
use App\Http\Middleware\Middleware;

class GuestMiddleware extends Middleware {

    public function __invoke($req, $res, $next) {

        if($this->auth->checkHost()) {

            return $res->withRedirect(
                $this->router->pathFor('auth.host', 
                    ['hostname' => $this->auth->host()->host_name]
                )
            );

        } elseif ($this->auth->checkUser()) {

            return $res->withRedirect(
                $this->router->pathFor('auth.user', 
                    ['username' => $this->auth->user()->user_name]
                )
            );

        }

        return $next($req, $res);
    }

}
