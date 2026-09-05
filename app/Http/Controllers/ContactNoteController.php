<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactNoteRequest;
use App\Models\Contact;
use App\Models\ContactNote;
use Illuminate\Http\RedirectResponse;

class ContactNoteController extends Controller
{
    /**
     * Store a note attached to a contact.
     */
    public function store(StoreContactNoteRequest $request, Contact $contact): RedirectResponse
    {
        $contact->notes()->create([
            'user_id' => $request->user()->id,
            'body' => $request->validated('body'),
        ]);

        return back()->with('success', 'Anotação adicionada.');
    }

    /**
     * Remove a note from a contact.
     */
    public function destroy(Contact $contact, ContactNote $note): RedirectResponse
    {
        abort_unless($note->contact_id === $contact->id, 404);

        $note->delete();

        return back()->with('success', 'Anotação removida.');
    }
}
