<?php

namespace App\Http\Controllers;

use App\Http\Requests\Translation\SearchRequest;
use App\Http\Requests\Translation\StoreRequest;
use App\Http\Requests\Translation\UpdateRequest;
use App\Http\Resources\TranslationResource;
use App\Models\Translation;
use App\Repositories\TranslationRepository;

class TranslationController extends Controller
{
    public function __construct(
        protected TranslationRepository $repository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        return TranslationResource::collection($this->repository->search($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $translation = $this->repository->create($request->validated());

        return TranslationResource::make($translation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Translation $translation)
    {
        return TranslationResource::make($this->repository->find($translation->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Translation $translation)
    {
        $updatedTranslation = $this->repository->update($translation, $request->validated());

        return TranslationResource::make($updatedTranslation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Translation $translation)
    {
        return $this->repository->delete($translation);
    }
}
