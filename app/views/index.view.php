<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Health Recording System' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0096FF',
                        secondary: '#E6F4FF',
                        accent: '#FF9500',
                        success: '#4CAF50',
                        warning: '#FFC107',
                        danger: '#FF5252',
                        light: '#F8FAFC',
                        dark: '#1E293B'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 min-h-screen font-sans text-gray-800">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="bx bx-plus-medical text-primary text-2xl"></i>
                <h1 class="text-xl font-semibold">Health Recording System</h1>
            </div>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="#" class="text-gray-600 hover:text-primary transition">Home</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-primary transition">History</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-primary transition">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Step Indicator -->
        <div class="mb-8 flex justify-center">
            <div class="flex items-center w-full max-w-3xl">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center">
                        <i class="bx bx-list-check"></i>
                    </div>
                    <span class="text-sm mt-2">Symptoms</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2 relative">
                    <div class="absolute inset-0 bg-primary" style="width: 50%"></div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center">
                        <i class="bx bx-info-circle"></i>
                    </div>
                    <span class="text-sm mt-2">Details</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center">
                        <i class="bx bx-analyse"></i>
                    </div>
                    <span class="text-sm mt-2">Analysis</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center">
                        <i class="bx bx-file"></i>
                    </div>
                    <span class="text-sm mt-2">Results</span>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <section class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Page Title -->
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-2xl font-bold text-center">Select Your Symptoms</h2>
                <p class="text-center text-gray-600 mt-2">Select all the symptoms you're experiencing. This will help us provide a more accurate analysis.</p>
            </div>

            <!-- Symptoms Form -->
            <form class="p-6">
                <!-- General Symptoms -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">General Symptoms</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border border-gray-200 rounded-md p-3 hover:bg-gray-50 transition">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" class="mt-1 h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <div class="ml-3">
                                    <span class="block font-medium">Fever</span>
                                    <span class="text-sm text-gray-500">Elevated body temperature</span>
                                </div>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3 hover:bg-gray-50 transition">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" class="mt-1 h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <div class="ml-3">
                                    <span class="block font-medium">Fatigue</span>
                                    <span class="text-sm text-gray-500">Extreme tiredness resulting from mental or physical exertion</span>
                                </div>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3 hover:bg-gray-50 transition">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" class="mt-1 h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <div class="ml-3">
                                    <span class="block font-medium">Chills</span>
                                    <span class="text-sm text-gray-500">Feeling of cold with shivering</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Head Symptoms -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Head Symptoms</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border border-gray-200 rounded-md p-3 hover:bg-gray-50 transition">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" class="mt-1 h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <div class="ml-3">
                                    <span class="block font-medium">Headache</span>
                                    <span class="text-sm text-gray-500">Pain in the head or upper neck</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Respiratory Symptoms -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Respiratory Symptoms</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border border-gray-200 rounded-md p-3 hover:bg-gray-50 transition">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" class="mt-1 h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <div class="ml-3">
                                    <span class="block font-medium">Cough</span>
                                    <span class="text-sm text-gray-500">Sudden expulsion of air from the lungs</span>
                                </div>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3 hover:bg-gray-50 transition">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" class="mt-1 h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <div class="ml-3">
                                    <span class="block font-medium">Shortness of Breath</span>
                                    <span class="text-sm text-gray-500">Difficulty breathing or catching your breath</span>
                                </div>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3 hover:bg-gray-50 transition">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" class="mt-1 h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <div class="ml-3">
                                    <span class="block font-medium">Nasal Congestion</span>
                                    <span class="text-sm text-gray-500">Blockage of the nasal passages</span>
                                </div>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3 hover:bg-gray-50 transition">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" class="mt-1 h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <div class="ml-3">
                                    <span class="block font-medium">Runny Nose</span>
                                    <span class="text-sm text-gray-500">Excess drainage produced by nasal tissues</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Throat Symptoms -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Throat Symptoms</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border border-gray-200 rounded-md p-3 hover:bg-gray-50 transition">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" class="mt-1 h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <div class="ml-3">
                                    <span class="block font-medium">Sore Throat</span>
                                    <span class="text-sm text-gray-500">Pain or irritation in the throat</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- More symptom categories would go here -->
                <!-- For brevity, I've included just a few categories -->

                <!-- Continue Button -->
                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-primary hover:bg-blue-600 text-white px-6 py-2 rounded-md flex items-center transition">
                        Continue
                        <i class="bx bx-right-arrow-alt ml-2"></i>
                    </button>
                </div>
            </form>
        </section>

        <!-- Additional Screens (Hidden by default, would be shown based on the current step) -->
        <div class="hidden">
            <!-- Symptom Details Screen -->
            <section class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-2xl font-bold text-center">Tell Us More About Your Symptoms</h2>
                </div>
                <div class="p-6">
                    <div class="mb-8 border-b pb-6">
                        <h3 class="text-lg font-semibold mb-4 text-accent">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Age</label>
                                <input type="number" placeholder="Your age" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Gender</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">Select gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Joint Pain</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">How severe is it?</label>
                                <div class="flex space-x-6">
                                    <label class="flex items-center">
                                        <input type="radio" name="severity" value="mild" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary">
                                        <span class="ml-2">Mild</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="severity" value="moderate" checked class="h-4 w-4 text-primary border-gray-300 focus:ring-primary">
                                        <span class="ml-2">Moderate</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="severity" value="severe" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary">
                                        <span class="ml-2">Severe</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">How long have you had this symptom?</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">Select duration</option>
                                    <option value="1day">Less than 24 hours</option>
                                    <option value="1week">1-7 days</option>
                                    <option value="2weeks">1-2 weeks</option>
                                    <option value="1month">2-4 weeks</option>
                                    <option value="3months">1-3 months</option>
                                    <option value="6months">3-6 months</option>
                                    <option value="1year">6-12 months</option>
                                    <option value="moreThan1year">More than 1 year</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Additional details</label>
                                <textarea rows="4" placeholder="Describe any additional details about this symptom" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between">
                        <button type="button" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-md flex items-center hover:bg-gray-50 transition">
                            <i class="bx bx-left-arrow-alt mr-2"></i>
                            Back
                        </button>
                        <button type="button" class="bg-primary hover:bg-blue-600 text-white px-6 py-2 rounded-md flex items-center transition">
                            Continue
                            <i class="bx bx-right-arrow-alt ml-2"></i>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Analysis Loading Screen -->
            <section class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-10 text-center">
                    <div class="flex justify-center mb-6">
                        <div class="text-primary">
                            <i class="bx bx-brain text-6xl"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold mb-4">Analyzing Your Symptoms</h2>
                    <p class="text-gray-600 mb-8">Our AI is processing your symptoms and medical data to provide personalized insights...</p>
                    
                    <div class="w-full max-w-md mx-auto mb-8">
                        <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full" style="width: 38%"></div>
                        </div>
                        <div class="text-right text-sm text-gray-500 mt-2">38% complete</div>
                    </div>
                    
                    <div class="space-y-4 max-w-lg mx-auto">
                        <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
                        <div class="h-4 bg-gray-200 rounded animate-pulse w-5/6"></div>
                        <div class="h-4 bg-gray-200 rounded animate-pulse w-4/6"></div>
                    </div>
                    
                    <div class="mt-10 border rounded-lg p-6">
                        <div class="flex justify-center space-x-2 mb-6">
                            <div class="w-4 h-16 bg-gray-200 rounded-full animate-pulse"></div>
                            <div class="w-4 h-24 bg-gray-200 rounded-full animate-pulse"></div>
                            <div class="w-4 h-32 bg-gray-200 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Results Screen -->
            <section class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-2xl font-bold text-center">AI Analysis Results</h2>
                    <p class="text-center text-gray-600 text-sm mt-1">Based on the symptoms you've shared, our AI has analyzed potential conditions and recommended treatments.</p>
                </div>
                
                <div class="p-6">
                    <!-- AI Insight -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-100 rounded-full p-2">
                                <i class="bx bx-bulb text-primary text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="font-semibold text-primary">AI Insight</h3>
                                <div class="mt-1 text-sm">
                                    <button class="text-primary hover:text-blue-700 flex items-center">
                                        <i class="bx bx-info-circle mr-1"></i>
                                        How was this calculated?
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-3">Symptom Summary</h3>
                            <p class="text-sm text-gray-600 mb-2">2 symptoms analyzed</p>
                            <div class="flex space-x-2">
                                <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Runny Nose</span>
                                <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Cough</span>
                            </div>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-3">Probability Distribution</h3>
                            <p class="text-sm text-gray-600 mb-2">Likelihood of potential conditions</p>
                            
                            <div class="space-y-2">
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span>Common Cold</span>
                                        <span>45%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 45%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span>Seasonal Allergies</span>
                                        <span>25%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 25%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Possible Conditions -->
                    <div class="mb-6">
                        <h3 class="flex items-center text-lg font-semibold mb-4">
                            <i class="bx bx-plus-medical text-primary mr-2"></i>
                            Possible Conditions
                        </h3>
                        
                        <!-- Condition Card - Common Cold -->
                        <div class="border rounded-lg mb-4 overflow-hidden bg-white">
                            <div class="bg-gray-50 px-4 py-3 border-b">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-semibold">Common Cold</h4>
                                    <div class="flex items-center">
                                        <span class="text-sm mr-2">Match: 34%</span>
                                        <div class="w-24 bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: 34%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-b">
                                <div class="flex">
                                    <button class="px-4 py-2 flex items-center text-sm font-medium border-b-2 border-primary text-primary" id="cold-info-tab">
                                        <i class="bx bx-info-circle mr-1.5"></i>
                                        Information
                                    </button>
                                    <button class="px-4 py-2 flex items-center text-sm font-medium text-gray-500 hover:text-gray-700" id="cold-treatment-tab">
                                        <i class="bx bx-plus-medical mr-1.5"></i>
                                        Treatment
                                    </button>
                                    <button class="px-4 py-2 flex items-center text-sm font-medium text-gray-500 hover:text-gray-700" id="cold-analysis-tab">
                                        <i class="bx bx-bar-chart-alt-2 mr-1.5"></i>
                                        Data Analysis
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Information Tab Content -->
                            <div class="p-4" id="cold-info-content">
                                <p class="text-sm mb-4">The common cold is a viral infection of your nose and throat (upper respiratory tract). It's usually harmless, although it might not feel that way.</p>
                                
                                <h5 class="font-medium mb-2">Common Symptoms:</h5>
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Sore Throat (not reported)</span>
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Nasal Congestion (not reported)</span>
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Runny Nose</span>
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Cough</span>
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Headache (not reported)</span>
                                </div>
                            </div>
                            
                            <!-- Treatment Tab Content (Initially Hidden) -->
                            <div class="p-4 hidden" id="cold-treatment-content">
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="bx bx-error text-yellow-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700 font-medium">Important Note</p>
                                            <p class="text-sm text-yellow-600">This information is for educational purposes only. Always consult with a healthcare professional for proper diagnosis and treatment.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="font-medium mb-2">Recommended Treatments:</h5>
                                <ul class="list-disc pl-5 space-y-1 text-sm">
                                    <li>Rest and sleep</li>
                                    <li>Stay hydrated</li>
                                    <li>Over-the-counter pain relievers</li>
                                    <li>Decongestants</li>
                                    <li>Throat lozenges</li>
                                </ul>
                            </div>
                            
                            <!-- Data Analysis Tab Content (Initially Hidden) -->
                            <div class="p-4 hidden" id="cold-analysis-content">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h5 class="font-medium mb-3">Symptom Match Analysis</h5>
                                        <div class="relative h-40 w-40 mx-auto">
                                            <!-- This would be a donut chart in a real implementation -->
                                            <div class="absolute inset-0 rounded-full border-8 border-gray-200"></div>
                                            <div class="absolute inset-0 rounded-full border-8 border-green-400 border-t-transparent border-r-transparent border-b-transparent"></div>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span class="text-xs text-gray-500">Unmatched: 3</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="font-medium mb-3">Key Indicators</h5>
                                        <div class="space-y-3">
                                            <div>
                                                <div class="flex justify-between text-sm mb-1">
                                                    <span>Symptom match rate:</span>
                                                    <span class="font-medium">40%</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-sm mb-1">
                                                    <span>Confidence score:</span>
                                                    <span class="font-medium">34%</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-sm mb-1">
                                                    <span>Severity level:</span>
                                                    <span class="font-medium text-green-500">Low</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Condition Card - Seasonal Allergies -->
                        <div class="border rounded-lg overflow-hidden bg-white">
                            <div class="bg-gray-50 px-4 py-3 border-b">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-semibold">Seasonal Allergies</h4>
                                    <div class="flex items-center">
                                        <span class="text-sm mr-2">Match: 23%</span>
                                        <div class="w-24 bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: 23%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-b">
                                <div class="flex">
                                    <button class="px-4 py-2 flex items-center text-sm font-medium border-b-2 border-primary text-primary" id="allergy-info-tab">
                                        <i class="bx bx-info-circle mr-1.5"></i>
                                        Information
                                    </button>
                                    <button class="px-4 py-2 flex items-center text-sm font-medium text-gray-500 hover:text-gray-700" id="allergy-treatment-tab">
                                        <i class="bx bx-plus-medical mr-1.5"></i>
                                        Treatment
                                    </button>
                                    <button class="px-4 py-2 flex items-center text-sm font-medium text-gray-500 hover:text-gray-700" id="allergy-analysis-tab">
                                        <i class="bx bx-bar-chart-alt-2 mr-1.5"></i>
                                        Data Analysis
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Information Tab Content -->
                            <div class="p-4" id="allergy-info-content">
                                <p class="text-sm mb-4">Seasonal allergies, sometimes called hay fever or allergic rhinitis, are allergy symptoms that occur during certain times of the year.</p>
                                
                                <h5 class="font-medium mb-2">Common Symptoms:</h5>
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Nasal Congestion (not reported)</span>
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Runny Nose</span>
                                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Sore Throat (not reported)</span>
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Cough</span>
                                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Headache (not reported)</span>
                                </div>
                            </div>
                            
                            <!-- Treatment Tab Content (Initially Hidden) -->
                            <div class="p-4 hidden" id="allergy-treatment-content">
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="bx bx-error text-yellow-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700 font-medium">Important Note</p>
                                            <p class="text-sm text-yellow-600">This information is for educational purposes only. Always consult with a healthcare professional for proper diagnosis and treatment.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="font-medium mb-2">Recommended Treatments:</h5>
                                <ul class="list-disc pl-5 space-y-1 text-sm">
                                    <li>Over-the-counter antihistamines</li>
                                    <li>Nasal corticosteroids</li>
                                    <li>Decongestants</li>
                                    <li>Avoiding allergen exposure</li>
                                    <li>Saline nasal irrigation</li>
                                </ul>
                            </div>
                            
                            <!-- Data Analysis Tab Content (Initially Hidden) -->
                            <div class="p-4 hidden" id="allergy-analysis-content">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h5 class="font-medium mb-3">Symptom Match Analysis</h5>
                                        <div class="relative h-40 w-40 mx-auto">
                                            <!-- This would be a donut chart in a real implementation -->
                                            <div class="absolute inset-0 rounded-full border-8 border-gray-200"></div>
                                            <div class="absolute inset-0 rounded-full border-8 border-green-400 border-t-transparent border-r-transparent"></div>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span class="text-xs text-gray-500">Unmatched: 3</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="font-medium mb-3">Key Indicators</h5>
                                        <div class="space-y-3">
                                            <div>
                                                <div class="flex justify-between text-sm mb-1">
                                                    <span>Symptom match rate:</span>
                                                    <span class="font-medium">23%</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-sm mb-1">
                                                    <span>Confidence score:</span>
                                                    <span class="font-medium">20%</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-sm mb-1">
                                                    <span>Severity level:</span>
                                                    <span class="font-medium text-green-500">Low</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- General Recommendations -->
                    <div class="mb-6">
                        <h3 class="flex items-center text-lg font-semibold mb-4">
                            <i class="bx bx-heart text-green-500 mr-2"></i>
                            General Recommendations
                        </h3>
                        
                        <div class="border rounded-lg p-4">
                            <ul class="space-y-3">
                                <li class="flex">
                                    <i class="bx bx-check-circle text-green-500 mt-0.5 mr-2"></i>
                                    <div>
                                        <p class="font-medium">Rest and hydration:</p>
                                        <p class="text-sm text-gray-600">Ensure you're getting adequate rest and staying well hydrated.</p>
                                    </div>
                                </li>
                                <li class="flex">
                                    <i class="bx bx-check-circle text-green-500 mt-0.5 mr-2"></i>
                                    <div>
                                        <p class="font-medium">Monitor symptoms:</p>
                                        <p class="text-sm text-gray-600">Keep track of any changes in your symptoms, especially if they worsen.</p>
                                    </div>
                                </li>
                                <li class="flex">
                                    <i class="bx bx-check-circle text-green-500 mt-0.5 mr-2"></i>
                                    <div>
                                        <p class="font-medium">Seek medical advice:</p>
                                        <p class="text-sm text-gray-600">Consult with a healthcare professional for a proper diagnosis, especially if symptoms persist or worsen.</p>
                                    </div>
                                </li>
                                <li class="flex">
                                    <i class="bx bx-check-circle text-green-500 mt-0.5 mr-2"></i>
                                    <div>
                                        <p class="font-medium">Follow up:</p>
                                        <p class="text-sm text-gray-600">Schedule a follow-up with a healthcare provider to monitor your condition.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="text-xs text-gray-500 mt-8 border-t pt-4">
                        <p>This analysis is based on the information you provided and is intended for informational purposes only. It is not a substitute for professional medical advice, diagnosis, or treatment.</p>
                    </div>
                    
                    <div class="mt-8 flex justify-between">
                        <button type="button" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-md flex items-center hover:bg-gray-50 transition">
                            <i class="bx bx-left-arrow-alt mr-2"></i>
                            Back to Details
                        </button>
                        <button type="button" class="bg-primary hover:bg-blue-600 text-white px-6 py-2 rounded-md flex items-center transition">
                            Return to Home
                            <i class="bx bx-home-alt ml-2"></i>
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-6">
        <div class="container mx-auto px-4">
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; <?= date('Y') ?> Health Recording System. All rights reserved.</p>
                <p class="mt-2">This system is for informational purposes only and is not a substitute for professional medical advice.</p>
            </div>
        </div>
    </footer>
</body>

<!-- Add JavaScript for tab functionality at the end of the body -->
<script>
    // Tab functionality for Common Cold
    document.getElementById('cold-info-tab').addEventListener('click', function() {
        showTab('cold', 'info');
    });
    document.getElementById('cold-treatment-tab').addEventListener('click', function() {
        showTab('cold', 'treatment');
    });
    document.getElementById('cold-analysis-tab').addEventListener('click', function() {
        showTab('cold', 'analysis');
    });
    
    // Tab functionality for Seasonal Allergies
    document.getElementById('allergy-info-tab').addEventListener('click', function() {
        showTab('allergy', 'info');
    });
    document.getElementById('allergy-treatment-tab').addEventListener('click', function() {
        showTab('allergy', 'treatment');
    });
    document.getElementById('allergy-analysis-tab').addEventListener('click', function() {
        showTab('allergy', 'analysis');
    });
    
    function showTab(condition, tab) {
        // Hide all tab contents for this condition
        document.getElementById(`${condition}-info-content`).classList.add('hidden');
        document.getElementById(`${condition}-treatment-content`).classList.add('hidden');
        document.getElementById(`${condition}-analysis-content`).classList.add('hidden');
        
        // Remove active state from all tabs
        document.getElementById(`${condition}-info-tab`).classList.remove('border-b-2', 'border-primary', 'text-primary');
        document.getElementById(`${condition}-treatment-tab`).classList.remove('border-b-2', 'border-primary', 'text-primary');
        document.getElementById(`${condition}-analysis-tab`).classList.remove('border-b-2', 'border-primary', 'text-primary');
        
        document.getElementById(`${condition}-info-tab`).classList.add('text-gray-500', 'hover:text-gray-700');
        document.getElementById(`${condition}-treatment-tab`).classList.add('text-gray-500', 'hover:text-gray-700');
        document.getElementById(`${condition}-analysis-tab`).classList.add('text-gray-500', 'hover:text-gray-700');
        
        // Show selected tab content
        document.getElementById(`${condition}-${tab}-content`).classList.remove('hidden');
        
        // Set active state for selected tab
        document.getElementById(`${condition}-${tab}-tab`).classList.remove('text-gray-500', 'hover:text-gray-700');
        document.getElementById(`${condition}-${tab}-tab`).classList.add('border-b-2', 'border-primary', 'text-primary');
    }
</script>

</html>