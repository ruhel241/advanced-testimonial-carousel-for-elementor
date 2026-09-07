<?php

namespace ATC\Models;

class GooglePlaces {


    protected $table = 'atcfe_google_places';
   
    public function getPlaces() {
        $places = atcfe_query()->table($this->table)
                ->orderBy('id', 'ASC')
                ->get();

        return $places;
    }

    public function getPlaceId($place_id) {
        $placeId = atcfe_query()->table($this->table)->where('place_id', $place_id)->first();

        return $placeId;
    }   
    

    // public function getTemplateSlug($slug)
    // {
    //     $template = atcfe_query()->table($this->table)->where('slug', $slug)->first();
    //     return $template;
    // }

    // public function isSlug($slug) {
    //     $isSlug =  atcfe_query()->table($this->table)->where('slug', $slug)->first();

    //     if ($isSlug) {
    //         return true;
    //     }

    //     return false;
    // }

    public function insertGetId($data) {
       
        $save = atcfe_query()->table($this->table)->insert($data);

        return $save;
    }


    public function update($id, $data) {
       
        $update = atcfe_query()->table($this->table)
                ->where('place_id', $id)
                ->update($data);

        return $update; 
    }

    public function deletePlace($place_id) {
        $delete = atcfe_query()->table($this->table)->where('place_id', $place_id)->delete();

        return $delete;
    }

}