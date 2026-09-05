<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'color',
    ];

    /**
     * Contacts assigned to this category.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'contact_category_id');
    }
}
