<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(5);
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request, [
           'title'=>'required',
           'body'=>'required',
           'cover_image' =>'image|nullable|mimes:jpeg,jpg,png|max:1999'
       ]);
                 // failu upload
                 if($request->hasFile('cover_image')){
                    // iegutfailu ar extension
                    $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                    // iegut tikai faila nosakumu
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // tikai ext
                    $extension = $request->file('cover_image')->getClientOriginalExtension();
                    // glabat failu
                    $fileNameToStore= $filename.'_'.time().'.'.$extension;
                    // upload attels
                    $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
                } else {
                    $fileNameToStore = 'noimage.jpg';
                }
       $post = new Post;
       $post->title = $request->input('title'); //ievade
       $post->body = $request->input('body');
       $post->user_id=auth()->user()->id;
       $post->cover_image = $fileNameToStore;
       $post->save();
       return redirect('/posts')->with('success', 'Post Created'); //atgriez atpakal
       
    } //

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id !=$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'=>'required',
            'body'=>'required',
            'cover_image' =>'image|nullable|mimes:jpeg,jpg,png|max:1999'

        ]);

         // failu upload
         if($request->hasFile('cover_image')){
            // iegutfailu ar extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // iegut tikai faila nosakumu
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // tikai ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // glabat failu
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // upload attelu
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        
        }
 
        $post =Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
    
        if ($request->hasFile('cover_image')) { //ja ir attels uzliek to, citadi liek defaulto attelu
            Storage::delete('public/cover_images/' . $post->cover_image); 
            $post->cover_image = $fileNameToStore;
        }
        $post->save();
        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);  //parbauda editu, vai pareizais lietotajs edito
        if(auth()->user()->id !=$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        if($post->cover_image != 'noimage.jpg'){
            // dzes attelu ja dzes postu
            Storage::delete('public/cover_images/'. $post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed');
    }


    public function render()
    {
        /* create new feed */
    $feed = \App::make("feed");
     /* cache the feed for 60 minutes */
    $feed->setCache(60);
 
    if (!$feed->isCached())
    {
    /* creating rss feed with our most recent 10 posts */
    $posts = \DB::table('posts')->orderBy('created_at', 'desc')->take(10)->get();
 
 
    /* set your feed's title, description, link, pubdate and language */
    $feed->title = 'Hello';
    $feed->description = 'Investmentnovel';
    $feed->logo = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkFjWxD55d3iK3CiSDDwH098fOEBIS7BilclaHwpjWt0Z0hTJDgQ';
    $feed->link = url('feed');
    $feed->setDateFormat('datetime');
    $feed->pubdate = $posts[0]->created_at;
    $feed->lang = 'en';
    $feed->setShortening(true);
    $feed->setTextLimit(100);

 
    foreach ($posts as $post)
    {
        $feed->add($post->title, \URL::to($post->title), $post->created_at, $post->body);
    }
 
  }
    return $feed->render('atom');
 }
    
}
