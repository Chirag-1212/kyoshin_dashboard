<?php 
    // Fallback values in case database is empty
    $title = isset($detail->Title) ? $detail->Title : 'Your Gateway to Japanese Language & Culture';
    $description = isset($detail->Description) ? $detail->Description : 'Founded in 2010...';
    $main_image = (isset($detail->DocPath) && $detail->DocPath != '') ? base_url($detail->DocPath) : base_url('assets/images/japan-student.jpg');
?>

<section id="about" class="py-20 bg-white relative" style="overflow: hidden;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center bg-white" style="display: grid; align-items: center;">
            
            <div class="order-2 md:order-1" style="order: 2;">
                <div class="rounded-2xl overflow-hidden shadow-xl" style="border-radius: 1rem; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                    <img 
                        src="<?php echo $main_image; ?>" 
                        alt="Japanese culture" 
                        class="w-full h-full object-cover" 
                        style="width: 100%; height: auto; display: block;"
                    >
                </div>
            </div>

            <div class="order-1 md:order-2 space-y-6" style="order: 1;">
                <div class="inline-block bg-blue-100 text-kyoshin-blue font-zilla font-bold px-4 py-2 rounded-full" 
                     style="display: inline-block; background-color: #dbeafe; color: #1e40af; padding: 0.5rem 1rem; border-radius: 9999px; font-weight: bold; margin-bottom: 1.5rem;">
                    About Us
                </div>
                
                <h2 class="text-5xl font-zilla font-bold text-kyoshin-blue" style="font-size: 3rem; font-weight: bold; color: #1e40af; line-height: 1.2; margin-bottom: 1.5rem;">
                    <?php echo $title; ?>
                </h2>

                <div class="text-kyoshin-black text-lg" style="font-size: 1.125rem; color: #1a1a1a; line-height: 1.7; margin-bottom: 1.5rem;">
                    <?php echo nl2br($description); ?>
                </div>

                <a href="<?php echo base_url('about-details'); ?>" class="btn-more" 
                   style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; background-color: #1e40af; color: white; padding: 1rem 2rem; border-radius: 0.5rem; text-decoration: none; transition: 0.3s;">
                    More About Us
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>

            <img 
                src="<?php echo base_url('assets/images/sakura.jpg'); ?>" 
                alt="Sakura" 
                class="absolute top-0 right-0 mix-blend-multiply opacity-20" 
                style="position: absolute; top: 0; right: 0; mix-blend-mode: multiply; height: 60%; opacity: 0.2; pointer-events: none; z-index: 0;"
            >
        </div>
    </div>
</section>

<style>
    /* Responsive Grid for older browsers or simple CSS */
    @media (min-width: 768px) {
        .grid { display: grid; grid-template-columns: 1fr 1fr; }
        .md\:order-1 { order: 1 !important; }
        .md\:order-2 { order: 2 !important; }
    }
    .btn-more:hover {
        background-color: #1d4ed8;
        transform: translateY(-2px);
    }
</style>