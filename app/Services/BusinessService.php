<?php

namespace App\Services;
use App\Repositories\BusinessRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusinessService
{
    protected $businessRepo;

    public function __construct(BusinessRepository $businessRepo)
    {
        $this->businessRepo = $businessRepo;
    }

    public function getAllBusinesses(array $filters = [])
    {
        return $this->businessRepo->all($filters);
    }

    public function getBusinessById($id)
    {
        return $this->businessRepo->find($id);
    }

    public function createBusiness(array $data)
    {
        // Có thể xử lý validate thêm logic ở đây nếu cần
        return $this->businessRepo->create($data);
    }

    public function updateBusiness($id, array $data)
    {
        return $this->businessRepo->update($id, $data);
    }

    public function deleteBusiness($id)
    {
        return $this->businessRepo->delete($id);
    }

    public function search(Request $request)
    {
        return $this->businessRepo->search($request);
    }

    public function searchByType(Request $request)
    {
        if($request->filled('type')){
            $type = $request->type ;

            return $this->businessRepo->searchByType($type);
        }
        return ['error'=>'Không tìm thấy doanh nghiệp nào!'];

    }
}
