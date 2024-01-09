<?php
declare(strict_types=1);

namespace Modules\Lender\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Lender\Http\Requests\Lender\CreateLenderRequest;
use Modules\Lender\Http\Requests\Lender\GetDetailLenderRequestCriteria;
use Modules\Lender\Http\Requests\Lender\GetListLenderRequestCriteria;
use Modules\Lender\Http\Requests\Lender\UpdateLenderRequest;
use Modules\Lender\Http\Resources\LenderResource;
use Modules\Lender\Models\Lender;

class LenderController extends Controller
{
    public function index(GetListLenderRequestCriteria $criteria, Request $request)
    {
        $data = $criteria->apply(Lender::query())->paginate($request->get('per_page') ?: 20);
        return LenderResource::collection($data);
    }

    public function show($uid, GetDetailLenderRequestCriteria $criteria)
    {
        $lender = $criteria->apply(Lender::query())->where('uid', $uid)->firstOrFail();
        return new LenderResource($lender);
    }

    public function store(CreateLenderRequest $request)
    {
        $lender = new Lender($request->all());
        $lender->save();
        return new LenderResource($lender->refresh());
    }

    public function update($uid, UpdateLenderRequest $request)
    {
        $lender = Lender::query()->where('uid', $uid)->firstOrFail();
        $lender->fill($request->all());
        $lender->save();
        return new LenderResource($lender->refresh());
    }

    public function destroy()
    {

    }
}
