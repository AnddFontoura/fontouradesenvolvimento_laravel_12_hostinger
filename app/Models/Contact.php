<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'contact_category_id',
        'name',
        'email',
        'phone',
        'best_contact_time',
        'message',
        'status',
    ];

    /**
     * Category assigned to the contact by an administrator.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ContactCategory::class, 'contact_category_id');
    }

    /**
     * Notes (ticket-like entries) attached to the contact.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(ContactNote::class)->latest();
    }
}
