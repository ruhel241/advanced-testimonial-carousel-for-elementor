<?php

namespace ATC\Models;

class GooglePlaces {


    protected $table = 'atc_google_places';
   
    public function getPlaces() {
        $places = atc_query()->table($this->table)
                ->orderBy('id', 'ASC')
                ->get();

        return $places;
    }

    public function getPlaceId($place_id) {
        $placeId = atc_query()->table($this->table)->where('place_id', $place_id)->first();

        return $placeId;
    }   
    
    public function getPlacesAutoFetch() {
        $places = atc_query()->table($this->table)
                ->where('auto_fetch', 'yes')
                ->get();
                
        return $places;
    }

    public function getPlacesIdAutoFetch($place_id) {
        $placeId = atc_query()->table($this->table)
                    ->where('place_id', $place_id)
                    ->where('auto_fetch', 1)
                    ->first();

        return $placeId;
    }  

    // public function getTemplateSlug($slug)
    // {
    //     $template = atc_query()->table($this->table)->where('slug', $slug)->first();
    //     return $template;
    // }

    // public function isSlug($slug) {
    //     $isSlug =  atc_query()->table($this->table)->where('slug', $slug)->first();

    //     if ($isSlug) {
    //         return true;
    //     }

    //     return false;
    // }

    public function insertGetId($data) {
       
        $save = atc_query()->table($this->table)->insert($data);

        return $save;
    }


    public function update($id, $data) {
       
        $update = atc_query()->table($this->table)
                ->where('place_id', $id)
                ->update($data);

        return $update; 
    }

    public function deletePlace($place_id) {
        $delete = atc_query()->table($this->table)->where('place_id', $place_id)->delete();

        return $delete;
    }

}