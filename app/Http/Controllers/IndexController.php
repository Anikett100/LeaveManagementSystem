<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
  
      public function addStory(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // dd($data);
            $story = new Story;
            $story->titleen = $data['titleen'];
            $story->titlefr = $data['titlefr'];
            $story->descriptionen = $data['descriptionen'];
            $story->descriptionfr = $data['descriptionfr'];

            if($request->hasFile('image')) {
                $image_tmp = $request->image;
                if ($image_tmp->isValid()) {
                    $filename = strtotime("now").'-'. $image_tmp->getClientOriginalName();
                    $newsviews_path = 'assets/imgs/story/'.$filename;
                    Image::make($image_tmp)->save($newsviews_path);
                    $story->image = $filename;
                }
            }
            $story->save();
           
            return redirect('admin/view-story')->with('flash_message_success','New record added successfully');
        }
        return view('admin.story.add-story');
    }
    
    // edit specific story
    public function editStory(Request $request, $id){
        if($request->isMethod('post')){
            $data = $request->all();

            if ($request->hasFile('image')) {
                $image_tmp = $request->image;
                $filename = time() . '.' . $image_tmp->clientExtension();
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(1111, 99999) . '.' . $extension;
                    $collaborate_path = 'assets/imgs/story/' . $filename;
                    Image::make($image_tmp)->save($collaborate_path);
                }
            } else if (!empty($data['current_image'])) {
                $filename = $data['current_image'];
            } else {
                $filename = '';
            }

           
            Story::where('id',$id)->update(['titleen'=>$data['titleen'],'titlefr'=>$data['titlefr'],'descriptionen'=>$data['descriptionen'],'descriptionfr'=>$data['descriptionfr'],'image'=>$filename,]);
            return redirect('admin/view-story')->with('flash_message_success','New record updated successfully');
        }
            $story = Story::where('id',$id)->first();
            return view('admin.story.edit-story')->with(compact('story'));
    }

     public function viewStory(){
        $story = Story::orderBy('id','ASC')->get();
        // dd($newsviewss);
        return view('admin.story.view-story')->with(compact('story'));
    }

    public function deleteStory(Request $request, $id){
        Story::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Data deleted successfully');
    }

}
