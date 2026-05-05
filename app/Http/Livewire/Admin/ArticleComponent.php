<?php

namespace App\Http\Livewire\Admin;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ArticleComponent extends Component
{
    use WithPagination,WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public Article $article;
    public $editableMode=false;
    public $mainImage;

    protected $rules=[
        'article.title'=>'required',
        'article.image'=>'nullable',
        'article.meta_title'=>'required',
        'article.meta_description'=>'nullable',
        'article.slug'=>'required',
        'article.content'=>'nullable',
        'article.published_on'=>'required',
        'article.status'=>'nullable',
        'article.status' => 'nullable',


        ];

    public function mount()
    {
        $this->article=new Article(['status'=>1,'published_on'=>now()->format('Y-m-d')]);
    }

    public function updatedArticleTitle($title)
    {
        $this->article->slug = Str::slug($title);
    }

    public function createOrEdit($id=null)
    {
        if($id)
        {
            $this->article=Article::find($id);
        }
        else{
            $this->article=new Article(['status'=>1,'published_on'=>now()->format('Y-m-d')]);
        }
        $this->editableMode=true;
    }

    public function cancelEdit()
    {
        $this->editableMode=false;
    }

    public function save()
    {

$this->article->status = $this->article->status ? true : false;
        $this->validate();
        if (!empty($this->mainImage)) {
                #move image to property folder
                $saved_image_path = 'storage/' . $this->mainImage->store('articles', 'public');
                #save image path to db
                $this->article->image=$saved_image_path;
                $this->mainImage=null;
        }
        if($this->article->id){
            $this->article->user_id=auth()->id();
        }
        $this->article->save();
        $this->editableMode=false;
        $this->dispatchBrowserEvent('success-notification',['message'=>'Article saved successfully.']);
    }

    public function delete($id)
    {
        Article::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'Article deleted successfully.']);
    }

    public function removeMainPhoto(){
        deleteFile($this->article->image);
        $this->article->update(['image'=>null]);
    }

    public function render()
    {
        return view('livewire.admin.article-component',['articles'=>Article::latest()->paginate(10)]);
    }
}
