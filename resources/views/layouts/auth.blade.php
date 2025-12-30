<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAMA - Marketplace Mahasiswa</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">
    <!-- Tailwind is compiled via PostCSS/Vite (npm). CDN removed for production/development build -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0); }
        }
        .animate-float { animation: float 3s ease-in-out infinite; }
        /* Intro overlay styles */
        .intro-overlay{position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;background:#009bf6;transition:transform .6s ease,opacity .4s ease;}
        .intro-overlay.hide{transform:translateY(-120%);opacity:0}
        .intro-logo{width:120px;height:120px;border-radius:9999px;background:transparent;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 24px rgba(0,0,0,0.12);transition:transform .55s cubic-bezier(.2,.8,.2,1),opacity .3s}
        .intro-logo img{width:96px;height:auto}
        .content-hidden{transform:translateY(18px);opacity:0;transition:transform .45s ease,opacity .35s ease}
        .content-show{transform:translateY(0);opacity:1}
        .choices-hidden{transform:translateY(30%);opacity:0;transition:transform .5s ease,opacity .45s ease}
        .choices-show{transform:translateY(0);opacity:1}
        .swipe-hint{position:absolute;left:50%;bottom:30px;transform:translateX(-50%);color:rgba(255,255,255,.95);font-weight:600;display:flex;flex-direction:column;align-items:center;gap:6px}
        .swipe-arrow{width:24px;height:24px;border-left:3px solid rgba(255,255,255,.95);border-bottom:3px solid rgba(255,255,255,.95);transform:rotate(-45deg);animation:arrow-bob 1s infinite}
        @keyframes arrow-bob{0%{transform:translateY(0) rotate(-45deg)}50%{transform:translateY(-6px) rotate(-45deg)}100%{transform:translateY(0) rotate(-45deg)}}
        /* overlay-actions contained in the app frame (not fixed to viewport) */
        .overlay-actions{position:relative;display:flex;flex-direction:column;gap:12px;padding:8px;justify-content:center;z-index:60;max-width:420px;margin:12px auto 0;box-sizing:border-box;width:100%}
        .overlay-actions a{display:block;width:100%;padding:14px 18px;border-radius:9999px;text-align:center;font-weight:700;box-shadow:0 6px 20px rgba(0,0,0,0.15);text-decoration:none;font-size:15px;box-sizing:border-box}
        /* default hidden - appear after reveal */
        .overlay-actions.choices-hidden{transform:translateY(20%);opacity:0;pointer-events:none}
        .overlay-actions.choices-show{transform:translateY(0);opacity:1;pointer-events:auto;transition:transform .45s ease,opacity .35s ease}
        /* Sign up: white bg, orange text; Login: orange bg, white text */
        .overlay-actions a.signup{background:#ffffff;color:#ff6600;border:2px solid rgba(255,255,255,0.9);box-shadow:0 10px 30px rgba(0,0,0,0.18);transition:transform .18s ease,box-shadow .18s}
        .overlay-actions a.signup:hover{transform:translateY(-3px);box-shadow:0 14px 36px rgba(0,0,0,0.22)}
        .overlay-actions a.login{background:#ff6600;color:#ffffff;box-shadow:0 10px 30px rgba(0,0,0,0.22);transition:transform .18s ease,box-shadow .18s}
        .overlay-actions a.login:hover{transform:translateY(-3px);box-shadow:0 14px 36px rgba(0,0,0,0.26)}
        .overlay-actions a:focus{outline:3px solid rgba(255,255,255,0.14);outline-offset:3px}
        @media (min-width:640px){
            .overlay-actions{max-width:420px;width:auto;left:50%;transform:translateX(-50%)}
            .overlay-actions a{font-size:16px;padding:12px 18px}
        }
        /* Keep the centered app-frame look after reveal */
        .app-frame.revealed{box-shadow:0 30px 70px rgba(2,6,23,0.12);border-radius:20px}

        /* Make the app-frame a column with scrollable main area so desktop stays neat */
        .app-frame{display:flex;flex-direction:column;max-height:92vh;overflow:hidden}
        #mainContent{flex:1;overflow:auto;-webkit-overflow-scrolling:touch}

        /* Pin actions inside the frame at its bottom */
        .overlay-actions{position:absolute;left:14px;right:14px;bottom:18px;max-width:none;margin:0;padding:6px 8px;display:flex;flex-direction:column;gap:12px}
        .overlay-actions a{width:100%}

        @media (min-width:1024px){
            .app-frame{max-width:520px}
            .app-frame.revealed{border-radius:24px}
            #mainContent{min-height:60vh}
        }
     </style>

     <body class="bg-[#f0f4f8] min-h-screen flex items-center justify-center overflow-auto transition-colors duration-500" id="pageBody">
    <!-- Intro overlay (initial full blue screen) -->
    <div id="introOverlay" class="intro-overlay" aria-hidden="true">
        <div id="introLogo" class="intro-logo">
            <img src="{{ asset('img/logo-mama.png') }}" alt="Logo MAMA">
        </div>
        <div class="swipe-hint" aria-hidden="true">
            <div class="swipe-arrow"></div>
            <div class="text-sm">Geser ke atas untuk mulai</div>
        </div>
    </div>

    <!-- overlay actions will be placed inside the centered app frame below -->
    <!-- duplicate external logo removed to keep the app-frame centered and stable -->

    <script>
        // Intro overlay behavior: stays until user swipe-up or tap; shows hint arrow
        (function(){
            const overlay = document.getElementById('introOverlay');
            const introLogo = document.getElementById('introLogo');
            const choices = document.querySelectorAll('.landing-choices');
            let touchStartY = null;

            function reveal(){
                if(!overlay) return;
                // slide overlay up first
                overlay.classList.add('hide');
                // when overlay fully hidden, remove it then reveal main content and buttons
                overlay.addEventListener('transitionend', ()=>{
                    overlay.remove();
                    // mark app-frame as revealed to preserve outer layout and styling
                    const appFrame = document.querySelector('.app-frame');
                    if(appFrame){ appFrame.classList.add('revealed'); }
                    // show main content animation
                    const main = document.getElementById('mainContent');
                    if(main){ main.classList.remove('content-hidden'); main.classList.add('content-show'); }
                    // reveal landing choices
                    choices.forEach(el=>{ el.classList.remove('choices-hidden'); el.classList.add('choices-show'); });
                    // show overlayActions (fixed buttons) after content revealed
                    const overlayActions = document.getElementById('overlayActions');
                    if(overlayActions){ overlayActions.classList.remove('choices-hidden'); overlayActions.classList.add('choices-show'); overlayActions.setAttribute('aria-hidden','false'); }
                }, {once:true});
            }

            // small logo scale animation on load (does NOT auto reveal)
            window.addEventListener('DOMContentLoaded', ()=>{
                setTimeout(()=>{ introLogo.style.transform = 'scale(.85)'; }, 300);
            });

            // click/tap reveals. prevent overlay close when clicking action links
            if(overlay){
                overlay.addEventListener('click', ()=> reveal());
                const actionLinks = document.querySelectorAll('#overlayActions a');
                actionLinks.forEach(a=> a.addEventListener('click', e=> e.stopPropagation()));

                // swipe handling: show overlayActions and move both overlay + buttons together during swipe
                let isDragging = false;
                let lastDelta = 0;
                const THRESHOLD = 100; // increase threshold for more intentional swipe

                function startDrag(y){
                    touchStartY = y;
                    isDragging = true;
                    lastDelta = 0;
                    // only pause overlay transition; DO NOT show action buttons yet
                    overlay.style.transition = 'none';
                }

                function moveDrag(y){
                    if(!isDragging || touchStartY === null) return;
                    const delta = Math.max(0, touchStartY - y); // positive when swiping up
                    lastDelta = delta;
                    const max = overlay.clientHeight || window.innerHeight;
                    const translate = Math.min(delta, max * 0.9); // limit translation
                    overlay.style.transform = `translateY(-${translate}px)`;
                    // progressively reveal landing choices visually (no buttons yet)
                    if(delta > 40){
                        choices.forEach(el=>{ el.classList.remove('choices-hidden'); el.classList.add('choices-show'); });
                    }
                }

                function endDrag(){
                    if(!isDragging) return;
                    isDragging = false;
                    overlay.style.transition = 'transform .45s ease, opacity .35s ease';
                    if(lastDelta > THRESHOLD){
                        reveal();
                    } else {
                        // revert overlay to initial
                        overlay.style.transform = '';
                        // hide any revealed landing choices again
                        setTimeout(()=>{
                            choices.forEach(el=>{ el.classList.remove('choices-show'); el.classList.add('choices-hidden'); });
                        }, 250);
                    }
                    touchStartY = null;
                }

                // touch events
                overlay.addEventListener('touchstart', e=> startDrag(e.touches[0].clientY));
                overlay.addEventListener('touchmove', e=>{ e.preventDefault(); moveDrag(e.touches[0].clientY); }, {passive:false});
                overlay.addEventListener('touchend', e=> endDrag());

                // mouse events for desktop
                overlay.addEventListener('mousedown', e=> startDrag(e.clientY));
                window.addEventListener('mousemove', e=>{ if(isDragging) moveDrag(e.clientY); });
                window.addEventListener('mouseup', e=> endDrag());
            }
        })();
    </script>

    <div class="app-frame w-full max-w-md mx-auto overflow-hidden bg-white md:rounded-xl relative">
        <div id="mainContent" class="w-full bg-mamaBlue rounded-t-[40px] px-8 pt-6 pb-32 relative min-h-[50vh] flex flex-col justify-start shadow-[0_-10px_40px_rgba(0,155,246,0.3)] content-hidden">

            <div class="w-12 h-1.5 bg-white/50 rounded-full mx-auto mb-8"></div>

            @yield('content')

        </div>

        <!-- actions contained within the app frame (will appear after reveal) -->
        <div id="overlayActions" class="overlay-actions choices-hidden" aria-hidden="true">
            <a href="{{ route('register') }}" class="signup">Sign up</a>
            <a href="{{ route('login') }}" class="login">Login</a>
        </div>
    </div>

</body>
</html>