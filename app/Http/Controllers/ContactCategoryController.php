<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactCategoryRequest;
use App\Http\Requests\UpdateContactCategoryRequest;
use App\Models\ContactCategory;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactCategoryController extends Controller
{
    /**
     * Display the categories management screen.
     */
    public function index(): Response
    {
        $categories = ContactCategory::query()
            ->withCount('contacts')
            ->orderBy('name')
            ->get();

        return Inertia::render('Categories/Index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a new category.
     */
    public function store(StoreContactCategoryRequest $request): RedirectResponse
    {
        ContactCategory::create($request->validated());

        return back()->with('success', 'Categoria criada com sucesso.');
    }

    /**
     * Update an existing category.
     */
    public function update(UpdateContactCategoryRequest $request, ContactCategory $category): RedirectResponse
    {
        $category->update($request->validated());

        return back()->with('success', 'Categoria atualizada com sucesso.');
    }

    /**
     * Delete a category. Contacts keep existing but lose the reference.
     */
    public function destroy(ContactCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Categoria removida com sucesso.');
    }
}
