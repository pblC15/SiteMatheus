(function () {
    "use strict";

    /* Menu mobile */
    var toggle = document.querySelector(".menu-toggle");
    var mobileMenu = document.querySelector(".menuMobile-content");

    if (toggle && mobileMenu) {
        toggle.addEventListener("click", function () {
            var isOpen = toggle.classList.toggle("is-open");
            mobileMenu.classList.toggle("is-open", isOpen);
            toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
        });

        mobileMenu.querySelectorAll("a").forEach(function (link) {
            link.addEventListener("click", function () {
                toggle.classList.remove("is-open");
                mobileMenu.classList.remove("is-open");
                toggle.setAttribute("aria-expanded", "false");
            });
        });
    }

    /* Máscara simples de telefone (substitui jquery.mask.js) */
    document.querySelectorAll('input[data-mask="phone"]').forEach(function (input) {
        input.addEventListener("input", function () {
            var digits = input.value.replace(/\D/g, "").slice(0, 11);
            var formatted = digits;
            if (digits.length > 10) {
                formatted = digits.replace(/(\d{2})(\d{5})(\d{0,4})/, "($1) $2-$3");
            } else if (digits.length > 5) {
                formatted = digits.replace(/(\d{2})(\d{4})(\d{0,4})/, "($1) $2-$3");
            } else if (digits.length > 2) {
                formatted = digits.replace(/(\d{2})(\d{0,5})/, "($1) $2");
            } else if (digits.length > 0) {
                formatted = digits.replace(/(\d{0,2})/, "($1");
            }
            input.value = formatted.replace(/-$/, "").replace(/\)$/, ") ").trim();
        });
    });

    /* Animações ao entrar na viewport */
    var animatedEls = document.querySelectorAll(".anime, .anime2, .anime3");
    function showAll() {
        animatedEls.forEach(function (el) {
            el.classList.add("anime-start", "anime2-start", "anime3-start");
        });
    }

    if ("IntersectionObserver" in window && animatedEls.length) {
        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        var el = entry.target;
                        if (el.classList.contains("anime")) el.classList.add("anime-start");
                        if (el.classList.contains("anime2")) el.classList.add("anime2-start");
                        if (el.classList.contains("anime3")) el.classList.add("anime3-start");
                        observer.unobserve(el);
                    }
                });
            },
            { threshold: 0.15 }
        );
        animatedEls.forEach(function (el) { observer.observe(el); });

        /* Rede de segurança contra JS lento/capturas de tela de página inteira */
        window.setTimeout(showAll, 2500);
    } else {
        showAll();
    }

    /* Alertas de envio do formulário de contato (via parâmetro da URL) */
    var params = new URLSearchParams(window.location.search);
    var status = params.get("id");
    if (status && window.swal) {
        if (status === "success") {
            swal("E-mail enviado com sucesso!", "Aguarde, entraremos em contato em breve.", "success");
        } else if (status === "error") {
            swal({
                title: "Erro ao enviar o e-mail",
                text: "Tente novamente mais tarde ou fale conosco pelo WhatsApp.",
                icon: "error",
                dangerMode: true
            });
        } else if (status === "alert") {
            swal({
                title: "Não foi possível enviar",
                text: "Preencha todos os campos obrigatórios e tente novamente.",
                icon: "warning",
                dangerMode: true
            });
        }
    }
})();
