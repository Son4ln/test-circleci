<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $kind
 * @property int $creativeroom_id
 * @property int $user_id
 * @property string $title
 * @property string $mime
 * @property string $path
 * @property string $thumb_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $videoUrl
 * @property string $thumbUrl
 */
class ProjectFile extends Model
{
    const PROJECT_FILE = 1;
    const PREVIEW_FILE = 2;
    const DELIVER_FILE = 3;

    /**
     * @var string
     */
    protected $table = 'project_files';

    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function captions()
    {
        return $this->hasMany(CreativeroomPreview::class, 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(CreativeRoom::class, 'creativeroom_id', 'id');
    }

    /**
     * @param $query
     * @param null $id
     * @return mixed
     */
    public function scopeProjectFile($query, $id = null)
    {
        if ($id) $query->where('project_files.project_id', $id);
        return $query->where('project_files.kind', 1)->orderBy('created_at', 'desc');
    }

    public function scopePreviewFile($query, $id = null)
    {
        if ($id) $query->where('project_files.project_id', $id);
        return $query->where('project_files.kind', 2)
            ->orderBy('created_at', 'desc');
    }

    public function scopePreviewGuest($query, $id = null)
    {
        if ($id) $query->where('project_files.id', $id);
        return $query->where('project_files.kind', 2);
    }


    public function scopeDeliverFile($query, $id = null)
    {
        if ($id) $query->where('project_files.project_id', $id);
        return $query->where('project_files.kind', 3)
            ->orderBy('created_at', 'desc');
    }
}
