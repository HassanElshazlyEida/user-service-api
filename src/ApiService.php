<?php

namespace Services;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class ApiService
{
    protected string $url;


    public function request($method,$path,$data = []) {
        $response = $this->getRequest($method,$path,$data);

        if($response->status() < 400) {
            return $response->json();
        }
        throw new HttpException($response->status(),$response->body());
    }
    public function getRequest($method,$path,$data = []) {
        return  \Http::acceptJson()->withHeaders(
        [
            'Authorization' => 'Bearer '.request()->bearerToken()
        ]
        )->$method($this->url.$path,$data);
    }
    public function post($path,$data) {
        return $this->request('post',$path,$data);
    }
    public function get($path) {
        return $this->request('get',$path);
    }
    public function put($path,$data) {
        return $this->request('put',$path,$data);
    }
    public function delete($path) {
        return $this->request('delete',$path);
    }
}