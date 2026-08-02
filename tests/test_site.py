"""
CRUZ Advocacia — Regression Test Suite
Garante que todas as funcionalidades implementadas permaneçam intactas.
Rodar: python3 tests/test_site.py
"""

import unittest
import re
import os
from contextlib import contextmanager

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

SUBPAGES = [
    'trabalhista.php', 'civil.php', 'criminal.php', 'bancario.php',
    'previdenciario.php', 'inventario.php', 'contato.php',
]


@contextmanager
def open_file(path):
    """Abre arquivo garantindo fechamento após uso."""
    f = open(os.path.join(ROOT, path), encoding='utf-8')
    try:
        yield f.read()
    finally:
        f.close()


def read(path):
    with open_file(path) as content:
        return content


# ── Patch CSS ────────────────────────────────────────────────────────────────

class TestPatchCSS(unittest.TestCase):
    """patch.css deve existir e conter todas as regras visuais."""

    def setUp(self):
        self.css = read('src/css/patch.css')

    def test_file_exists(self):
        self.assertTrue(os.path.exists(os.path.join(ROOT, 'src/css/patch.css')))

    def test_hero_video_opacity(self):
        self.assertIn('.hero_bg_video', self.css)
        self.assertIn('opacity:.40', self.css)

    def test_photo_opacity_60(self):
        self.assertIn('.sobre_right img', self.css)
        self.assertIn('opacity:.60', self.css)

    def test_photo_hover_100(self):
        self.assertIn('.sobre_right:hover img', self.css)
        self.assertIn('opacity:1', self.css)

    def test_map_box_caramel(self):
        self.assertIn('.endereco_left .btn_mapa', self.css)
        self.assertIn('#d4b87a', self.css)
        self.assertIn('#c8a96e', self.css)

    def test_footer_svg_sizing(self):
        self.assertIn('.footer_tright .btn_footer svg', self.css)
        self.assertIn('width:2rem', self.css)
        self.assertIn('fill:#fff', self.css)

    def test_footer_brand_colors(self):
        self.assertIn('#1877F2', self.css)   # Facebook
        self.assertIn('#dc2743', self.css)   # Instagram
        self.assertIn('#25d366', self.css)   # WhatsApp

    def test_hover_green_nav_button(self):
        self.assertIn('a.nav_button:hover', self.css)

    def test_hover_green_btn_home(self):
        self.assertIn('a.btn_home:hover', self.css)

    def test_hover_green_whatsapp_buttons(self):
        self.assertIn('a.btn_wpp_hero:hover', self.css)
        self.assertIn('a.btn_wpp_cta:hover', self.css)
        self.assertIn('a.btn_footer[href*="whatsapp"]:hover', self.css)

    def test_hover_green_card(self):
        self.assertIn('.card_body:hover .btn_card', self.css)

    def test_especialidades_padding(self):
        self.assertIn('.section_especialidades', self.css)
        self.assertIn('padding:80px 10%', self.css)


# ── Router (index.php) ───────────────────────────────────────────────────────

class TestRouter(unittest.TestCase):
    """Router principal deve injetar patch.css e processar a página inicial."""

    def setUp(self):
        self.router = read('index.php')

    def test_injects_patch_css(self):
        self.assertIn('patch.css', self.router)

    def test_requires_main_page(self):
        self.assertIn('src/pages/index.php', self.router)

    def test_str_replace_head(self):
        self.assertIn('</head>', self.router)


# ── Página principal (src/pages/index.php) ───────────────────────────────────

class TestMainPage(unittest.TestCase):
    """Página principal deve ter SVGs, mapa correto e contadores."""

    def setUp(self):
        self.html = read('src/pages/index.php')

    def test_map_url_uses_coordinates(self):
        self.assertIn('-26.4939913,-49.0811204', self.html)
        self.assertNotIn('?q=+554732731422', self.html)
        self.assertNotIn('Cruz+Advocacia+Advogado', self.html)

    def test_counter_elements_present(self):
        self.assertIn('class="counter"', self.html)
        self.assertIn('data-target=', self.html)

    def test_footer_svg_facebook(self):
        self.assertIn('viewBox="0 0 320 512"', self.html)  # Facebook-F
        self.assertNotIn('fa-facebook-f', self.html)

    def _footer_section(self):
        m = re.search(r'footer_tright.*?</div>', self.html, re.DOTALL)
        return m.group(0) if m else ''

    def test_footer_svg_instagram(self):
        footer = self._footer_section()
        self.assertIn('aria-label="Instagram CRUZ Advocacia"', footer)
        self.assertNotIn('fa-instagram', footer)

    def test_footer_svg_whatsapp(self):
        footer = self._footer_section()
        self.assertIn('aria-label="Atendimento WhatsApp"', footer)
        self.assertNotIn('fa-brands fa-whatsapp', footer)

    def test_footer_svg_scale(self):
        self.assertIn('viewBox="0 0 640 512"', self.html)  # scale-balanced
        footer = self._footer_section()
        self.assertNotIn('fa-scale-balanced', footer)

    def test_footer_svg_search(self):
        self.assertIn('viewBox="0 0 512 512"', self.html)  # magnifying-glass
        footer = self._footer_section()
        self.assertNotIn('fa-magnifying-glass', footer)

    def test_footer_svg_map(self):
        self.assertIn('viewBox="0 0 384 512"', self.html)  # location-dot
        footer = self._footer_section()
        self.assertNotIn('fa-map-location-dot', footer)

    def test_btn_mapa_color_green_original(self):
        self.assertIn('--var:#1ea73c', self.html)

    def test_scripts_loaded(self):
        self.assertIn('src/js/script.js', self.html)
        self.assertIn('src/js/wpp-widget.js', self.html)


# ── Subpages ─────────────────────────────────────────────────────────────────

class TestSubpages(unittest.TestCase):
    """Todas as subpages devem ter patch.css, SVGs e cache-key dinâmico."""

    def _check_subpage(self, fname):
        content = read(fname)

        with self.subTest(file=fname, check='patch.css'):
            self.assertIn('patch.css', content)

        with self.subTest(file=fname, check='dynamic cache key'):
            self.assertNotIn('?id=30072026000003', content)
            self.assertIn('$refreshkey', content)
            self.assertIn('echo $refreshkey', content)

        with self.subTest(file=fname, check='wpp-widget loaded'):
            self.assertIn('wpp-widget.js', content)

        with self.subTest(file=fname, check='svg facebook no fa class'):
            self.assertNotIn('fa-facebook-f', content)

        with self.subTest(file=fname, check='svg instagram no fa class'):
            self.assertNotIn('fa-instagram', content)

        with self.subTest(file=fname, check='svg whatsapp footer no fa class'):
            footer_section = re.search(
                r'footer_tright.*?</div>', content, re.DOTALL)
            if footer_section:
                self.assertNotIn('fa-brands fa-whatsapp',
                                 footer_section.group(0))

    def test_all_subpages(self):
        for fname in SUBPAGES:
            self._check_subpage(fname)


# ── .htaccess ────────────────────────────────────────────────────────────────

class TestHtaccess(unittest.TestCase):
    """.htaccess deve redirecionar /mapa para coordenadas exatas."""

    def setUp(self):
        self.htaccess = read('.htaccess')

    def test_mapa_redirect_uses_coordinates(self):
        self.assertIn('-26.4939913,-49.0811204', self.htaccess)

    def test_mapa_redirect_not_phone(self):
        self.assertNotIn('?q=+554732731422', self.htaccess)

    def test_mapa_redirect_not_name_search(self):
        self.assertNotIn('Cruz+Advocacia+Advogado', self.htaccess)

    def test_security_headers_present(self):
        self.assertIn('Strict-Transport-Security', self.htaccess)
        self.assertIn('X-Frame-Options', self.htaccess)
        self.assertIn('Content-Security-Policy', self.htaccess)


# ── WhatsApp Widget (wpp-widget.js) ──────────────────────────────────────────

class TestWppWidget(unittest.TestCase):
    """Widget WhatsApp deve ter SVG, pulso, timer de inatividade e fluxo correto."""

    def setUp(self):
        self.js = read('src/js/wpp-widget.js')

    def test_svg_icon_constant(self):
        self.assertIn('WPP_ICON', self.js)
        self.assertIn('<svg', self.js)
        self.assertIn('viewBox="0 0 448 512"', self.js)

    def test_no_fa_brands_whatsapp(self):
        self.assertNotIn('fa-brands fa-whatsapp', self.js)

    def test_pulse_animation_defined(self):
        self.assertIn('wppPulse', self.js)

    def test_pulse_element_created(self):
        self.assertIn('wppPulse', self.js)
        self.assertIn('border-radius:50%', self.js)

    def test_inactivity_timer_constant_exists(self):
        self.assertIn('INACTIVITY_MS', self.js)

    def test_inactivity_timer_is_8000ms(self):
        self.assertIn('INACTIVITY_MS  = 8000', self.js)

    def test_panel_closes_on_inactivity(self):
        self.assertIn('closePanel', self.js)
        self.assertIn('_startInactivityTimer', self.js)
        self.assertIn('_clearInactivityTimer', self.js)

    def test_widget_styles_injected_on_init(self):
        self.assertIn('injectWidgetStyles', self.js)

    def test_cms_whatsapp_hidden(self):
        self.assertIn('hideCmsWhatsApp', self.js)

    def test_phone_number_correct(self):
        self.assertIn('5547991313686', self.js)

    def test_whatsapp_url_built_from_answers(self):
        self.assertIn('buildWhatsAppUrl', self.js)
        self.assertIn('api.whatsapp.com', self.js)

    def test_whatsapp_url_encodes_text(self):
        self.assertIn('encodeURIComponent', self.js)

    def test_conversation_areas_defined(self):
        self.assertIn('Trabalhista', self.js)
        self.assertIn('Previdenciário', self.js)
        self.assertIn('Criminal', self.js)

    def test_conversation_asks_timeframe(self):
        self.assertIn('askTimeframe', self.js)
        self.assertIn('Menos de 1 mês', self.js)

    def test_closing_message_urgency(self):
        self.assertIn('prazo legal', self.js)

    def test_panel_auto_closes_after_whatsapp_click(self):
        self.assertIn('closePanel(panel)', self.js)
        self.assertIn('3000', self.js)

    def test_no_dead_code_inject_animation_style(self):
        """injectAnimationStyle não deve existir — era no-op removido."""
        self.assertNotIn('injectAnimationStyle', self.js)

    def test_use_strict(self):
        self.assertIn("'use strict'", self.js)

    def test_iife_pattern(self):
        self.assertIn('(function WhatsAppWidget()', self.js)

    def test_report_includes_area(self):
        self.assertIn('answers.area', self.js)

    def test_report_includes_detail(self):
        self.assertIn('answers.detalhe', self.js)

    def test_report_includes_timeframe(self):
        self.assertIn('answers.tempo', self.js)


# ── script.js ────────────────────────────────────────────────────────────────

class TestScriptJS(unittest.TestCase):
    """script.js deve ter contador, sticky header e proteções."""

    def setUp(self):
        self.js = read('src/js/script.js')

    def test_counter_animation(self):
        self.assertIn('animateCounter', self.js)
        self.assertIn('IntersectionObserver', self.js)

    def test_counter_two_phases(self):
        self.assertIn('PHASE_1_DURATION_MS', self.js)
        self.assertIn('PHASE_2_INTERVAL_MS', self.js)

    def test_counter_format_ptbr(self):
        self.assertIn("toLocaleString('pt-BR')", self.js)

    def test_sticky_header(self):
        self.assertIn('STICKY_SCROLL_THRESHOLD', self.js)
        self.assertIn('sticky', self.js)

    def test_mobile_visibility(self):
        self.assertIn('MOBILE_HIDDEN_SELECTORS', self.js)
        self.assertIn('applyMobileVisibility', self.js)

    def test_content_protection(self):
        self.assertIn('contextmenu', self.js)
        self.assertIn('preventDefault', self.js)

    def test_use_strict(self):
        self.assertIn("'use strict'", self.js)

    def test_hero_video_orientation(self):
        self.assertIn('setHeroVideoOrientation', self.js)
        self.assertIn('orientation: portrait', self.js)

    def test_passive_event_listeners(self):
        self.assertIn('passive: true', self.js)


# ── deploy.sh ────────────────────────────────────────────────────────────────

class TestDeployScript(unittest.TestCase):
    """deploy.sh deve usar API Hostinger (TUS) e não FTP."""

    def setUp(self):
        self.sh = read('deploy.sh')

    def test_uses_hostinger_api(self):
        self.assertIn('developers.hostinger.com', self.sh)

    def test_uses_tus_protocol(self):
        self.assertIn('upload-offset', self.sh)
        self.assertIn('upload-length', self.sh)

    def test_no_ftp(self):
        self.assertNotIn('ftp://', self.sh)

    def test_token_env_var(self):
        self.assertIn('HOSTINGER_API_TOKEN', self.sh)

    def test_deploy_index_php_allowed(self):
        self.assertIn('"index.php"', self.sh)

    def test_deploy_patch_css_or_explicit(self):
        self.assertIn('FILES=("$@")', self.sh)


if __name__ == '__main__':
    unittest.main(verbosity=2)
