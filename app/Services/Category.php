<?php

namespace App\Services;


class Category
{
/*
    public function getCategories()
    {

        $categories=\App\Categori::where('parent_id',0)->get();//united

        $categories=$this->addRelation($categories);

        return $categories;

    }

    protected function selectChild($id)
    {
        $categories=\App\Categori::where('parent_id',$id)->get(); //rooney

        $categories=$this->addRelation($categories);

        return $categories;

    }

    protected function addRelation($categories)
    {

        $categories->map(function ($item, $key) {

            $sub=$this->selectChild($item->id);

            return $item=array_add($item,'subCategory',$sub);

        });

        return $categories;
    }
*/
    public function deleteCat($id)
    {
        $count = \App\Categori::where(['parent_id' => $id])->get()->count();

        if ($count>0) {
            $curitem = \App\Categori::where(['parent_id'=>$id])->get();

             foreach($curitem as $k => $item) {
                $this->deleteCat($item->id);
             }
        }
        $cat = \App\Categori::find($id);
        //dd($cat);
        //dd($cat);
        //echo $id."-";
        //sleep(1);
        if ($cat) {
            \App\Categori::where('id',$id)->delete();
        }
        //
    }

}
