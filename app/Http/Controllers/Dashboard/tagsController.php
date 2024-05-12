<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use DB;

class tagsController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('dashboard.tags.create');
    }

    public function store(TagRequest $request)
    {
        try {
            DB::beginTransaction();
            $tags = Tag::create($request->except('_token'));

            //save translations
            $tags->name = $request->name;

            DB::commit();
            return redirect()->route('admin.tags.create')->with(['success' => 'Created successfully']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.tags.create')->with(['error' => 'Created failed']);
        }
    }

    public function edit($id)
    {
        $tags = Tag::find($id);

        if (!$tags) {
            return redirect()->route('admin.tags')->with(['error' => 'this tag not found']);
        }

        return view('dashboard.tags.edit', compact('tags'));
    }

    public function update($id, TagRequest $request)
    {
        try {
            $tags = Tag::find($id);
            if (!$tags) {
                return redirect()->route('admin.tags')->with(['error' => 'this tag not found']);
            }

            DB::beginTransaction();
            $tags->update($request->except('_token', 'id'));
            // save name
            $tags->name = $request->name;
            $tags->save();

            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'Updated successfully']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.tags')->with(['error' => 'Updated failed']);
        }
    }

    public function delete($id)
    {
        try {
            $tags = Tag::find($id);
            if (!$tags) {
                return redirect()->route('admin.tags')->with(['error' => 'هذا الماركة غير موجود ']);
            }

            $tags->delete();
            return redirect()->route('admin.tags')->with(['success' => 'Deleted successfully']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.tags')->with(['error' => 'Deleted failed']);
        }
    }
}
