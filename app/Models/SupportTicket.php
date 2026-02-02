<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;
    
    protected $connection = 'master';

    protected $fillable = [
        'title',
        'bus_config_id',
        'priority',
        'status',
        'description',
        'created_by',
    ];

    public function businessConfiguration()
    {
        return $this->belongsTo(BusinessConfiguration::class, 'bus_config_id', 'bus_config_id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class, 'ticket_id');
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id');
    }

    public function history()
    {
        return $this->hasMany(TicketHistory::class, 'ticket_id');
    }
}
