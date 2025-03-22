<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yatri Visit Details – Puri Dham</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 to-purple-100 p-4 min-h-screen flex items-center justify-center">
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded shadow">
        {{ session('error') }}
    </div>
@endif

    <div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-center text-purple-700 mb-6">Yatri Visit Details – Puri Dham</h2>
        
            <form action="{{ route('yatri.store') }}" method="post"  class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf

            <!-- Yatri Name -->
            <div class="flex items-center bg-purple-50 rounded-md shadow-sm">
                <span class="p-2 text-purple-600">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" name="yatri_name" placeholder="Yatri Name" required class="w-full p-2 rounded-r-md outline-none">
            </div>

            <!-- Mobile Number -->
            <div class="flex items-center bg-green-50 rounded-md shadow-sm">
                <span class="p-2 text-green-600">
                    <i class="fas fa-phone"></i>
                </span>
                <input type="tel" name="mobile_no" placeholder="Mobile Number" required class="w-full p-2 rounded-r-md outline-none">
            </div>

            <!-- WhatsApp Number -->
            <div class="flex items-center bg-green-100 rounded-md shadow-sm">
                <span class="p-2 text-green-700">
                    <i class="fab fa-whatsapp"></i>
                </span>
                <input type="tel" name="whatsapp_no" placeholder="WhatsApp Number" class="w-full p-2 rounded-r-md outline-none">
            </div>

            <!-- Email -->
            <div class="flex items-center bg-yellow-50 rounded-md shadow-sm">
                <span class="p-2 text-yellow-600">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" placeholder="Email" class="w-full p-2 rounded-r-md outline-none">
            </div>

            <!-- Coming Date -->
            <div class="flex items-center bg-blue-50 rounded-md shadow-sm">
                <span class="p-2 text-blue-600">
                    <i class="fas fa-calendar-plus"></i>
                </span>
                <input type="date" name="coming_date" required class="w-full p-2 rounded-r-md outline-none">
            </div>

            <!-- Going Date -->
            <div class="flex items-center bg-red-50 rounded-md shadow-sm">
                <span class="p-2 text-red-600">
                    <i class="fas fa-calendar-minus"></i>
                </span>
                <input type="date" name="date_of_going" required class="w-full p-2 rounded-r-md outline-none">
            </div>

          
            <!-- Landmark -->
            <div class="flex items-center bg-indigo-50 rounded-md shadow-sm">
                <span class="p-2 text-indigo-600">
                    <i class="fas fa-map-marker-alt"></i>
                </span>
                <input type="text" name="landmark" placeholder="Landmark" class="w-full p-2 rounded-r-md outline-none">
            </div>

            <!-- City/Village -->
            <div class="flex items-center bg-blue-50 rounded-md shadow-sm">
                <span class="p-2 text-blue-700">
                    <i class="fas fa-city"></i>
                </span>
                <input type="text" name="city_village" placeholder="City/Village" class="w-full p-2 rounded-r-md outline-none">
            </div>

            <!-- District -->
            <div class="flex items-center bg-orange-50 rounded-md shadow-sm">
                <span class="p-2 text-orange-600">
                    <i class="fas fa-map"></i>
                </span>
                <input type="text" name="district" placeholder="District" class="w-full p-2 rounded-r-md outline-none">
            </div>

            <!-- State -->
            <div class="flex items-center bg-teal-50 rounded-md shadow-sm">
                <span class="p-2 text-teal-600">
                    <i class="fas fa-flag"></i>
                </span>
                <input type="text" name="state" placeholder="State" class="w-full p-2 rounded-r-md outline-none">
            </div>

            <!-- Country -->
            <div class="flex items-center bg-lime-50 rounded-md shadow-sm">
                <span class="p-2 text-lime-600">
                    <i class="fas fa-globe"></i>
                </span>
                <input type="text" name="country" placeholder="Country" class="w-full p-2 rounded-r-md outline-none">
            </div>

              <!-- Description -->
              <div class="col-span-1 sm:col-span-2 flex items-start bg-pink-50 rounded-md shadow-sm">
                <span class="p-2 text-pink-600 pt-3">
                    <i class="fas fa-align-left"></i>
                </span>
                <textarea name="description" rows="3" placeholder="Description" class="w-full p-2 rounded-r-md outline-none"></textarea>
            </div>


            <!-- Save Button -->
            <div class="col-span-1 sm:col-span-2 text-center mt-4">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-2 rounded-full shadow-lg transition duration-300">
                    <i class="fas fa-save mr-2"></i> Save
                </button>
            </div>
        </form>
    </div>

</body>
</html>
