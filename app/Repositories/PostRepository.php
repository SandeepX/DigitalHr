<?php

namespace App\Repositories;


use App\Models\Post;

class PostRepository
{

    public function getAllDepartmentPosts($with=[],$select=['*'])
    {
        return Post::with($with)->select($select)->latest()->paginate(Post::RECORDS_PER_PAGE);
    }

    public function store($validatedData)
    {
        return Post::create($validatedData)->fresh();
    }

    public function getPostById($id)
    {
        return Post::where('id',$id)->first();
    }

    public function delete($postDetail)
    {
        return $postDetail->delete();
    }

    public function update($postDetail,$validatedData)
    {
        return $postDetail->update($validatedData);
    }

    public function toggleStatus($id)
    {
        $postDetail = Post::where('id',$id)->first();
        return $postDetail->update([
            'is_active' => !$postDetail->is_active,
        ]);
    }

    public function getAllActivePostsByDepartmentId($deptId,$with=[],$select=['*'])
    {
        return Post::with($with)
            ->select($select)
            ->where('is_active',1)
            ->where('dept_id',$deptId)
            ->get();
    }
}
