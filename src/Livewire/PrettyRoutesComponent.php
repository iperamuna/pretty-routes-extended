<?php

namespace Iperamuna\PrettyRoutesExtended\Livewire;

use Iperamuna\PrettyRoutesExtended\Models\Route as RouteModel;
use Livewire\Component;

class PrettyRoutesComponent extends Component
{
    public string $search = '';

    public string $searchField = 'uri'; // uri, name, action

    public string $filter = 'all';

    public array $selectedRows = [];

    public function toggleRow(int $id): void
    {
        if (in_array($id, $this->selectedRows)) {
            $this->selectedRows = array_diff($this->selectedRows, [$id]);
        } else {
            $this->selectedRows[] = $id;
        }
    }

    public function render(): \Illuminate\View\View
    {
        $query = RouteModel::query();

        if ($this->filter !== 'all') {
            $query->where('uri', 'like', $this->filter.'%');
        }

        if ($this->search) {
            $query->where($this->searchField, 'like', '%'.$this->search.'%');
        }

        $routes = $query->get();

        return view('pretty-routes-extended::livewire.pretty-routes', [
            'routes' => $routes,
            'totalCount' => RouteModel::count(),
            'filterOptions' => $this->generateFilterOptions(),
        ]);
    }

    private function generateFilterOptions(): array
    {
        $uris = RouteModel::pluck('uri')->unique();
        $options = [];

        foreach ($uris as $uri) {
            $parts = explode('/', $uri);
            $count = count($parts);

            if ($count == 1) {
                $options[] = $parts[0];
            } else {
                $current = '';
                for ($i = 0; $i < $count - 1; $i++) {
                    $part = $parts[$i];
                    if (str_starts_with($part, '{')) {
                        continue;
                    }

                    if ($current) {
                        $current .= '/'.$part;
                    } else {
                        $current = $part;
                    }
                    $options[] = $current;
                }
            }
        }

        $options = array_unique($options);
        sort($options);

        return $options;
    }
}
