<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('member_code', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        [$perPage, $sort, $direction] = $this->listQueryParams($request, ['name', 'email', 'member_code', 'status', 'created_at'], 'created_at');
        $members = $query->orderBy($sort, $direction)->paginate($perPage)->withQueryString();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $member = Member::create($data);

        return redirect()->route('members.index')
            ->with('success', "Member \"{$member->name}\" created.");
    }

    public function show(Member $member)
    {
        $currentLoans = $member->loans()->with('book')->where('status', 'borrowed')->latest('loaned_at')->get();
        $pastLoans = $member->loans()->with('book')->where('status', 'returned')->latest('returned_at')->limit(15)->get();

        return view('members.show', compact('member', 'currentLoans', 'pastLoans'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $data = $this->validated($request, $member->id);
        $member->update($data);

        return redirect()->route('members.show', $member)
            ->with('success', "Member \"{$member->name}\" updated.");
    }

    public function destroy(Member $member)
    {
        $name = $member->name;
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', "Member \"{$name}\" deleted.");
    }

    private function validated(Request $request, ?int $memberId = null): array
    {
        return $request->validate([
            'member_code' => 'required|string|max:32|unique:members,member_code,'.($memberId ?? 'NULL'),
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:32',
            'address' => 'nullable|string',
            'joined_at' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);
    }
}
