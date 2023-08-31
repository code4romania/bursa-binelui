<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        //"id" => 1
        //    "name" => "Toth-Popescu dasdasd"
        //    "cif" => "1629208165"
        //    "description" => "Eum occaecati doloremque provident molestias. Fuga rerum totam sit rem. Ut voluptas est id ut laudantium. Corrupti impedit mollitia qui delectus. Earum recusand ▶"
        //    "street_address" => "Calea Brăduțului"
        //    "contact_person" => "Amanda Neagoe"
        //    "contact_phone" => "0742380766"
        //    "contact_email" => "arina93@sirbu.com"
        //    "website" => "http://www.groza.net/ex-sapiente-dolorum-sit.html"
        //    "accepts_volunteers" => 1
        //    "why_volunteer" => "Amet deserunt fuga dolor nihil quis et minima. Officiis iusto tempore sequi quis beatae architecto. Vero atque blanditiis libero quam illo. Dolorum laborum aut  ▶"
        //    "status" => "active"
        //    "eu_platesc_merchant_id" => "44840998340"
        //    "eu_platesc_private_key" => "0C4D2EAA6F3E343A7FE74B04C83A66E9BEE882E3"
        //    "created_at" => "2023-08-31 12:27:37"
        //    "updated_at" => "2023-08-31 13:02:29"
        //    "deleted_at" => null
        //    "status_updated_at" => null
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cif' => $this->cif,
            'counties' => $this->counties->map(function ($county) {
                return $county->name;
            })->implode(', ') ?? '',
            'activity_domains' => $this->activityDomains->map(function ($activityDomain) {
                return $activityDomain->name;
            })->implode(', '),
            'logo' => $this->getFirstMediaUrl('logo','preview'),
            'statute_link' => $this->getFirstMediaUrl('organizationFilesStatute'),
            'description' => $this->description,
            'street_address' => $this->street_address,
            'contact_person' => $this->contact_person,
            'contact_phone' => $this->contact_phone,
            'contact_email' => $this->contact_email,
            'website' => $this->website,
            'accepts_volunteers' => $this->accepts_volunteers,
            'why_volunteer' => $this->why_volunteer,
            'status' => $this->status,
            'eu_platesc_merchant_id' => !empty($this->eu_platesc_merchant_id),
            'eu_platesc_private_key' => !empty($this->eu_platesc_private_key),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,


        ];
    }
}
