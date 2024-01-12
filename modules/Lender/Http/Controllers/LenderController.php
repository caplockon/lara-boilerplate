<?php
declare(strict_types=1);

namespace Modules\Lender\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Lender\Http\Requests\Lender\CreateLenderRequest;
use Modules\Lender\Http\Requests\Lender\GetDetailLenderRequestCriteria;
use Modules\Lender\Http\Requests\Lender\GetListLenderRequestCriteria;
use Modules\Lender\Http\Requests\Lender\UpdateLenderRequest;
use Modules\Lender\Http\Resources\LenderResource;
use Modules\Lender\Models\Address;
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
        $lender->load(['address']);
        return new LenderResource($lender);
    }

    public function store(CreateLenderRequest $request)
    {
        $lender = new Lender($data = $request->all());
        $lender->save();

        $addressData = $data['address'] ?? null;
        if ($addressData) {
            $lender->address()->create($addressData);
        }
        return new LenderResource($lender->refresh());
    }

    public function update($uid, UpdateLenderRequest $request)
    {
        /** @var Lender $lender */
        $lender = Lender::query()->where('uid', $uid)->firstOrFail();
        $lender->fill($data = $request->all());
        $lender->save();

        $addressData = $data['address'] ?? null;
        if ($addressData) {
            $address = $lender->address ?? new Address();
            $address->fill($addressData);
            $lender->address()->save($address);
        }

        return new LenderResource($lender->refresh());
    }

    public function destroy()
    {

    }
}
