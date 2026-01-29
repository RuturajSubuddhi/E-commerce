<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqList = Faq::all();
        return view('adminPanel.setting.faq', compact('faqList'));
    }

    public function create()
    {
        return view('adminPanel.setting.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
        ]);

        Faq::create($request->only('title', 'details'));

        return redirect()->back()->with('success', 'FAQ Added successfully!');
    }


    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('adminPanel.setting.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->only('title', 'details'));

        return redirect()->back()->with('success', 'FAQ updated successfully!');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return back()->with('success', 'FAQ deleted successfully!');
    }
}
