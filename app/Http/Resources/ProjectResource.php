<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dynamicAttributes = [];
        foreach ($this->attributeValues as $attributeValue) {
            $dynamicAttributes[$attributeValue->attribute->name] = $attributeValue->value;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'attributes' => $dynamicAttributes,
            'attribute_values' => AttributeValueResource::collection($this->whenLoaded('attributeValues')),
        ];
    }
}
