<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\ContactCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    /**
     * Display a paginated, filterable list of contact attempts.
     */
    public function index(Request $request): Response
    {
        $filters = [
            'name' => $request->string('name')->trim()->value(),
            'email' => $request->string('email')->trim()->value(),
            'phone' => $request->string('phone')->trim()->value(),
            'best_contact_time' => $request->string('best_contact_time')->trim()->value(),
            'status' => $request->string('status')->trim()->value(),
            'contact_category_id' => $request->string('contact_category_id')->trim()->value(),
        ];

        $contacts = Contact::query()
            ->with('category')
            ->when($filters['name'], fn ($query, $value) => $query->where('name', 'like', "%{$value}%"))
            ->when($filters['email'], fn ($query, $value) => $query->where('email', 'like', "%{$value}%"))
            ->when($filters['phone'], fn ($query, $value) => $query->where('phone', 'like', "%{$value}%"))
            ->when($filters['best_contact_time'], fn ($query, $value) => $query->where('best_contact_time', $value))
            ->when($filters['status'], fn ($query, $value) => $query->where('status', $value))
            ->when($filters['contact_category_id'], fn ($query, $value) => $query->where('contact_category_id', $value))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts,
            'filters' => $filters,
            'categories' => ContactCategory::orderBy('name')->get(['id', 'name', 'color']),
        ]);
    }

    /**
     * Display a single contact with its notes.
     */
    public function show(Contact $contact): Response
    {
        $contact->load([
            'category',
            'notes.author:id,name',
        ]);

        return Inertia::render('Contacts/Show', [
            'contact' => $contact,
            'categories' => ContactCategory::orderBy('name')->get(['id', 'name', 'color']),
        ]);
    }

    /**
     * Update the category and status of a contact.
     */
    public function update(UpdateContactRequest $request, Contact $contact): RedirectResponse
    {
        $contact->update($request->validated());

        return back()->with('success', 'Contato atualizado com sucesso.');
    }

    /**
     * Store a new contact attempt from the public site.
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        Contact::create($request->validated());

        return back()->with('success', 'Mensagem enviada com sucesso! Em breve entraremos em contato.');
    }
}
