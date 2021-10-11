<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Api test') }}
        </h2>
    </x-slot>
    <table>
        <thead>
            <th>
                name
            </th>
            <th>
                email
            </th>
            <th>
                gender
            </th>
            <th>
                status
            </th>
        </thead>
        <tbody>
            @forelse ($users['data'] as $user)
            <tr>
                <td>
                    {{ $user['name'] }}
                </td>
                <td>
                    {{ $user['email'] }}
                </td>
                <td>
                    {{ $user['gender'] }}
                </td>
                <td>
                    {{ $user['status'] }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Not found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</x-app-layout>