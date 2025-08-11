<?php

namespace App\Repositories;

use App\Models\Translation;

class TranslationRepository extends BaseRepository
{
    public function __construct(Translation $translation)
    {
        $this->model = $translation;
    }

    public function search(array $data)
    {
        $query = $this->model->newQuery();

        if (isset($data['key'])) {
            $query->where('key', 'like', '%' . $data['key'] . '%');
        }

        if (isset($data['value'])) {
            $query->where('value', 'like', '%' . $data['value'] . '%');
        }

        if (isset($data['tags'])) {
            $query->whereHas('tags', function ($qry) use ($data) {
                $qry->whereIn('name', $data['tags']);
            });
        }

        $perPage = isset($data['per_page']) ? $data['per_page'] : 15;

        return $query->paginate($perPage);
    }
}
