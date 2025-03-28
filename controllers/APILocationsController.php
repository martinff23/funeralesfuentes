<?php

namespace Controllers;

use Model\Branch;
use Model\Category;
use Model\Cemetery;
use Model\Chapel;
use Model\Crematory;

class APILocationsController{

    public static function locations(){
        $locations = [];
        $branches = Branch::allWhere('status', 'ACTIVE');
    
        if ($branches && count($branches) > 0) {
            foreach ($branches as $branch) {
                $category = Category::find($branch->category_id);
    
                $tmp_location = [
                    'id' => $branch->id,
                    'name' => $branch->branch_name,
                    'iso' => $branch->branch_ISO,
                    'address' => $branch->address,
                    'telephone' => $branch->telephone,
                    'category_type' => $category->type,
                    'category_subtype' => $category->subtype,
                    'category_name' => $category->visible_name,
                    'latitude' => $branch->latitude,
                    'longitude' => $branch->longitude
                ];
    
                $locations[] = $tmp_location;
            }
        }
    
        $chapels = Chapel::allWhere('status', 'ACTIVE');
    
        if ($chapels && count($chapels) > 0) {
            foreach ($chapels as $chapel) {
                $category = Category::find($chapel->category_id);
    
                $tmp_location = [
                    'id' => $chapel->id,
                    'name' => $chapel->chapel_name,
                    'iso' => '',
                    'address' => $chapel->address,
                    'telephone' => '0',
                    'category_type' => $category->type,
                    'category_subtype' => $category->subtype,
                    'category_name' => $category->visible_name,
                    'latitude' => $chapel->latitude,
                    'longitude' => $chapel->longitude
                ];
    
                $locations[] = $tmp_location;
            }
        }
    
        $cemeteries = Cemetery::allWhere('status', 'ACTIVE');
    
        if ($cemeteries && count($cemeteries) > 0) {
            foreach ($cemeteries as $cemetery) {
                $category = Category::find($cemetery->category_id);
    
                $tmp_location = [
                    'id' => $cemetery->id,
                    'name' => $cemetery->cemetery_name,
                    'iso' => '',
                    'address' => $cemetery->address,
                    'telephone' => '0',
                    'category_type' => $category->type,
                    'category_subtype' => $category->subtype,
                    'category_name' => $category->visible_name,
                    'latitude' => $cemetery->latitude,
                    'longitude' => $cemetery->longitude
                ];
    
                $locations[] = $tmp_location;
            }
        }
    
        $crematories = Crematory::allWhere('status', 'ACTIVE');
    
        if ($crematories && count($crematories) > 0) {
            foreach ($crematories as $crematory) {
                $category = Category::find($crematory->category_id);
    
                $tmp_location = [
                    'id' => $crematory->id,
                    'name' => $crematory->crematory_name,
                    'iso' => '',
                    'address' => $crematory->address,
                    'telephone' => '0',
                    'category_type' => $category->type,
                    'category_subtype' => $category->subtype,
                    'category_name' => $category->visible_name,
                    'latitude' => $crematory->latitude,
                    'longitude' => $crematory->longitude
                ];
    
                $locations[] = $tmp_location;
            }
        }

        echo json_encode($locations);
    }
    

}