<?php

namespace App\Repositories;

use App\Models\Business;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusinessRepository
{
    protected $model;

    public function __construct(Business $model)
    {
        $this->model = $model;
    }

    public function all(array $filters = [])
    {
        return $this->model->with(['country', 'city', 'district', 'ward'])
            ->filter($filters)
            ->latest()
            ->get();
    }

    public function find($id)
    {
        return $this->model->with(['products', 'country', 'city'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $business = $this->find($id);
        $business->update($data);
        return $business;
    }

    public function delete($id)
    {
        $business = $this->find($id);
        return $business->delete();
    }

    public function searchByType($type)
    {
        $query = Business::with('products');

        if ($type && $type != 'all') {
            $query->where('dashboard_type', $type);
        }

        return $query->get();
    }


    public function search(Request $request)
    {
        $query = Business::query();

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->filled('key_search')) {
            $keyword = trim($request->key_search);
            $query->where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhereHas('city', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', '%' . $keyword . '%');
                });
        }

        if ($request->filled('type')) {
            $query->where('dashboard_type', $request->type);
        }

        if ($request->filled('price_from') && $request->filled('price_to')) {
            $priceFrom = $request->input('price_from');
            $priceTo = $request->input('price_to');

            $query->where(function ($q) use ($priceFrom, $priceTo) {
                $q->where('price_to', '>=', $priceFrom)
                    ->where('price_from', '<=', $priceTo);
            });
        }

        $needAvgStar = false;

        if ($request->filled('sort_by')) {
            $sortBy = $request->input('sort_by');
            if (in_array($sortBy, ['rating_asc', 'rating_desc'])) {
                $needAvgStar = true;
            }
        }

        if ($request->filled('star')) {
            $needAvgStar = true;
        }

        if ($needAvgStar) {
            $query->withAvg('reviews', 'star');
        }

        if ($request->filled('star')) {
            $stars = $request->input('star');
            if (is_array($stars)) {
                $query->havingRaw('ROUND(reviews_avg_star) IN (' . implode(',', array_map('intval', $stars)) . ')');
            }

        }

        if ($request->filled('sort_by')) {
            $sortBy = $request->sort_by;
            switch ($sortBy) {
                case 'rating_asc':
                    $query->orderBy('reviews_avg_star', 'asc');
                    break;
                case 'rating_desc':
                    $query->orderBy('reviews_avg_star', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price_to', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price_to', 'desc');
                    break;
            }
        }

        $query->whereHas('products', function ($q) use ($request) {

            if ($request->filled('usage_quantity')) {
                $q->where('usage_quantity', '>=', (int)$request->usage_quantity);
            }

            if ($request->filled('place_quantity')) {
                $q->where('place_quantity', '>=', (int)$request->place_quantity);
            }

            if ($request->filled('children_quantity')) {
                $q->where('child_quantity', '>=', (int)$request->children_quantity);
            }

//            if ($request->filled('price_from') && $request->filled('price_to')) {
//                $q->whereHas('productPrice', function ($priceQ) use ($request) {
//                    Log::debug($request->price_from);
//                    Log::debug($request->price_to);
//                    $priceQ->whereBetween('price', [$request->price_from, $request->price_to]);
//                });
//            }
            if ($request->filled('booking_date')) {
                $start = Carbon::parse($request->booking_date);

                if ($request->filled('booking_end_date')) {
                    $end = Carbon::parse($request->booking_end_date);
                } else {
                    $end = $start->copy()->addHours(2);
                }

                if ($start->format('H:i:s') === '00:00:00' && $end->format('H:i:s') === '00:00:00') {
                    $start = $start->startOfDay();
                    $end = $end->endOfDay();
                }

                $q->whereDoesntHave('bookings', function ($bookingQ) use ($start, $end) {
                    $bookingQ->where(function ($subQ) use ($start, $end) {
                        $subQ->whereBetween('start_time', [$start, $end])
                            ->orWhereBetween('end_time', [$start, $end])
                            ->orWhere(function ($subQ2) use ($start, $end) {
                                $subQ2->where('start_time', '<=', $start)
                                    ->where('end_time', '>=', $end);
                            });
                    });
                });
            }
        });

        $perPage = $request->input('perPage', 20);
        $currentPage = $request->input('currentPage', 1);
        return $query
            ->with(['products.productPrice'])
            ->paginate($perPage, ['*'], 'page', $currentPage);

    }

    public function searchByName($name)
    {
        return Business::query()->where('name', 'LIKE', '%' . $name . '%')->get();
    }
}

