<button {{$attributes->merge(['type' => 'submit', 'class' => 'btn-primary bg-gray-200 border-2 border-dark-gray hover:bg-dark-gray hover:border-black w-full hover:text-white'])}}>

    {{$slot}}

</button>
