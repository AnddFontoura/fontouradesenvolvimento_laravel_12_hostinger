<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    /**
     * Display a paginated list of contact attempts.
     */
    public function index(): Response
    {
        $contacts = Contact::query()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * Store a new contact attempt from the site.
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        Contact::create($request->validated());

        return back()->with('success', 'Mensagem enviada com sucesso! Em breve entraremos em contato.');
    }
}
