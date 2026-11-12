<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'category', 'name', 'company', 'email', 'phone', 'project',
        'site_country', 'required_by', 'details',
        'attachment_path', 'attachment_name', 'emailed_at', 'handled_at',
    ];

    /**
     * Who should be notified about this request, or null when no address is configured yet.
     * Tools requests go to the tools address when there is one, everything else to sales.
     */
    public function recipient(): ?string
    {
        $mail = config('site.mail');

        if (in_array($this->category, $mail['tools_categories'], true) && filled($mail['tools'])) {
            return $mail['tools'];
        }

        return filled($mail['sales']) ? $mail['sales'] : null;
    }

    protected function casts(): array
    {
        return [
            'required_by' => 'date',
            'emailed_at' => 'datetime',
            'handled_at' => 'datetime',
        ];
    }
}
