<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Complaint;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            $counts = [
                'total' => Complaint::count(),
                'pending' => Complaint::where('status', 'pending')->count(),
                'done' => Complaint::where('status', 'done')->count(),
            ];
            return view('welcome', compact('categories', 'counts'));
        } catch (\Exception $e) {
            return response()->make("
                <div style='font-family: sans-serif; padding: 20px; text-align: center;'>
                    <h1>Database Connection Error</h1>
                    <p>Sepertinya database belum disetting atau belum dimigrasi.</p>
                    <p>Error: " . $e->getMessage() . "</p>
                    <hr>
                    <h2 style='color: red;'>SOLUSI:</h2>
                    <p>Silakan buka link ini untuk setup database otomatis:</p>
                    <a href='" . url('/migrate') . "' style='background: blue; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 1.2em;'>KLIK DISINI: Setup Database (/migrate)</a>
                </div>
            ", 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'guest_email' => 'nullable|email',
        ]);

        $data = $request->only(['title', 'body', 'category_id', 'guest_email', 'guest_telp', 'is_anonymous', 'student_name', 'student_class']);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('complaints', 'public');
            $data['image'] = $path;
        }

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        $complaint = Complaint::create($data);

        return redirect()->route('complaints.success', ['ticket_id' => $complaint->ticket_id]);
    }

    public function success($ticket_id) {
        $complaint = Complaint::where('ticket_id', $ticket_id)->firstOrFail();
        return view('complaints.success', compact('complaint'));
    }

    public function track(Request $request)
    {
        if ($request->has('ticket_id')) {
            $complaint = Complaint::where('ticket_id', $request->ticket_id)->first();
            if ($complaint) {
                return view('complaints.track', compact('complaint'));
            } else {
                return back()->with('error', 'Tiket tidak ditemukan!');
            }
        }
        return view('complaints.track');
    }
    
    public function show($ticket_id) {
         $complaint = Complaint::where('ticket_id', $ticket_id)->with(['responses.user', 'category'])->firstOrFail();
         
         // Logic to protect private complaints
         // If anonymous AND private -> only admin can see (or user with session? hard for anonymous)
         // For now, if we assume public tracking requires ID, that's "auth" enough for anonymous unless marked strictly private.
         
         return view('complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, $ticket_id) {
        $complaint = Complaint::where('ticket_id', $ticket_id)->firstOrFail();
        $complaint->status = $request->status;
        $complaint->save();
        return back()->with('success', 'Status berhasil diperbarui!');
    }

    public function storeResponse(Request $request, $ticket_id) {
        $request->validate(['body' => 'required']);
        $complaint = Complaint::where('ticket_id', $ticket_id)->firstOrFail();
        
        Response::create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'body' => $request->body
        ]);
        
        // Auto update status to process if it was pending
        if($complaint->status == 'pending') {
            $complaint->status = 'process';
            $complaint->save();
        }

        return back()->with('success', 'Tanggapan terkirim!');
    }
}
