<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\WithActiveStatus;

class Program extends Model
{
    use HasFactory, WithActiveStatus;
    protected $fillable = [
        'title',
        'venue',
        'age_group',
        'price',
        'pick_and_drop',
        'content',
        'slug',
        'meta_title',
        'meta_description',
        'category_id',
        'overview',
        'start_date',
        'booked_slots',
        'total_slots',
        'end_date',
        'age_group_extra_info',
        'status',
        'form_id',
        'activities_1',
        'activities_2',
        'activities_3',
        'activities_4',

    ];


    protected static function boot()
    {
        parent::boot();

        // When saving (could be create or update) the modal
        static::deleting(function ($program) {
            foreach ($program->images as $image) {
                $image->delete();
            }
        });
    }

    public function overviewTrimmed()
    {
        return  strip_tags(substr($this->overview, 0, 75)) . ' ...';
    }


    public function category()
    {
        return $this->belongsTo(ProgramCategory::class)->withDefault();
    }

    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }

    public function morePrograms()
    {
        return $this->category->programs->where('id', '!=', $this->id)->where('status', 1)->take(3);
    }

    public function form()
    {
        return $this->belongsTo(Form::class)->withDefault();
    }

    public function timetables()
    {
        return $this->hasMany(TimeTable::class);
    }

    public function groups()
    {
        return $this->hasMany(ProgramGroup::class);
    }

    public function haveGroups()
    {
        return count($this->groups);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_program');
    }

    public function hasActivities()
    {
        return $this->activities_1 || $this->activities_2 || $this->activities_3 || $this->activities_4;
    }
}
