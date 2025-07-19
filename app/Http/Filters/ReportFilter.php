<?php

namespace App\Http\Filters;

class ReportFilter extends QueryFilter
{

    public function include($value)
    {
        $relations = array_map('trim', explode(',', $value));

        return $this->builder->with($relations);
    }

    public function id($value)
    {
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function code($value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('code', 'like', $likeStr);
    }
  
    public function name($value)
    {
      $likeStr = str_replace('*', '%', $value);
      return $this->builder->where('name', 'like', $likeStr);
    }

    public function created_at($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }

    public function perPage($value)
    {
        $this->perPage = (int) $value;
        return $this;
    }

    public function page($value)
    {
        $this->page = (int) $value;
        return $this;
    }

    public function pagination($value)
    {
        $this->paginate = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        return $this;
    }

    public function isPaginated()
    {
        return $this->paginate;
    }
}