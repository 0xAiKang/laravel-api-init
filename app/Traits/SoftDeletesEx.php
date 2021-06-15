<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 软删除
 *
 * Trait SoftDeletesEx
 *
 * @package App\Traits
 */
trait SoftDeletesEx
{
    use SoftDeletes;

    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootSoftDeletes()
    {
        static::addGlobalScope(new SoftDeletingScopeEx());
    }

    /**
     * Get the name of the "deleted at" column.
     *
     *
     * @return string
     */
    public function getDeletedAtColumn()
    {
        // 自定义标识字段
        return 'is_deleted';
    }

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return void
     */
    protected function runSoftDelete()
    {
        $query = $this->newQueryWithoutScopes()->where($this->getKeyName(), $this->getKey());

        // 0. 正常 1. 已删除
        $this->{$this->getDeletedAtColumn()} = $time = 1;

        $query->update([
            $this->getDeletedAtColumn() => $time
        ]);
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function restore()
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('restoring') === false) {
            return false;
        }

        $this->{$this->getDeletedAtColumn()} = 0;

        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('restored', false);

        return $result;
    }

    /**
     * Determine if the model instance has been soft-deleted.
     *
     * @return bool
     */
    public function trashed()
    {
        return ! ($this->{$this->getDeletedAtColumn()} === 0);
    }
}
