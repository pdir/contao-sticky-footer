# Contao Sticky Footer

Sticky footer for the Contao back end with pure CSS and no JavaScript. The save
buttons of every edit form stay visible at the bottom of the screen, so you no
longer have to scroll down long forms to save.

[Deutsche Version](#deutsch)

## Features

- Save buttons (`.tl_formbody_submit`) stick to the bottom of the viewport
- Works in the main back end view, in pop-ups (modal windows) and on mobile devices
- Adds the class `debug` to the `<body>` when debug mode is active, so the footer
  sits above the Symfony debug toolbar
- No configuration, no JavaScript

## Requirements

- PHP 8.1 or higher
- Contao 5.3 or Contao 6

Use version 1.1 for Contao 4.13.

## Installation

Install via Contao Manager (search for `pdir/contao-sticky-footer`) or Composer:

```bash
composer require pdir/contao-sticky-footer
```

That's it. The stylesheet is loaded automatically in the back end; there is
nothing to configure.

## Usage

1. Log in to the Contao back end.
2. Open any record for editing, e.g. a page, an article or a content element.
3. The buttons "Save", "Save and close" etc. are now always visible at the bottom
   of the window, no matter how long the form is.

### Debug mode

If the debug mode is enabled (Contao Manager › "Debug mode" or `APP_ENV=dev` in
your `.env.local`), the bundle adds the class `debug` to the `<body>` of the back
end. The sticky footer is then moved up by 36px so it is not covered by the
Symfony debug toolbar.

You can use this class in your own back end stylesheets as well:

```css
body.debug #header {
    background: #c33;
}
```

## Development

The styles live in `public/sticky-footer.scss` and are compiled to
`public/sticky-footer.css`.

Run the coding standard and the unit tests before you release the bundle:

```bash
vendor/bin/ecs check src/ tests/ --fix
vendor/bin/phpunit
```

## License

GPL-3.0-or-later, see [LICENSE](LICENSE).

---

## Deutsch

Sticky Footer für das Contao-Backend mit purem CSS und ohne JavaScript. Die
Speichern-Buttons jedes Bearbeitungsformulars bleiben am unteren Bildschirmrand
sichtbar, langes Scrollen zum Speichern entfällt.

### Funktionen

- Speichern-Buttons (`.tl_formbody_submit`) bleiben am unteren Rand des Fensters
- Funktioniert in der Backend-Hauptansicht, in Pop-ups (Modal-Fenster) und auf
  mobilen Geräten
- Fügt dem `<body>` die Klasse `debug` hinzu, wenn der Debug-Modus aktiv ist,
  damit der Footer über der Symfony-Debug-Toolbar liegt
- Keine Konfiguration, kein JavaScript

### Voraussetzungen

- PHP 8.1 oder höher
- Contao 5.3 oder Contao 6

Für Contao 4.13 Version 1.1 verwenden.

### Installation

Über den Contao Manager (nach `pdir/contao-sticky-footer` suchen) oder per
Composer installieren:

```bash
composer require pdir/contao-sticky-footer
```

Fertig. Das Stylesheet wird im Backend automatisch geladen, eine Konfiguration
ist nicht nötig.

### Anleitung

1. Im Contao-Backend anmelden.
2. Einen beliebigen Datensatz bearbeiten, z. B. eine Seite, einen Artikel oder
   ein Inhaltselement.
3. Die Buttons „Speichern“, „Speichern und schließen“ usw. sind jetzt immer am
   unteren Fensterrand sichtbar, egal wie lang das Formular ist.

#### Debug-Modus

Ist der Debug-Modus aktiv (Contao Manager › „Debug-Modus“ oder `APP_ENV=dev` in
der `.env.local`), bekommt der `<body>` im Backend die Klasse `debug`. Der Sticky
Footer wird dann um 36px nach oben versetzt, damit ihn die Symfony-Debug-Toolbar
nicht verdeckt.

Die Klasse lässt sich auch in eigenen Backend-Stylesheets nutzen:

```css
body.debug #header {
    background: #c33;
}
```

### Entwicklung

Die Styles liegen in `public/sticky-footer.scss` und werden nach
`public/sticky-footer.css` kompiliert.

Vor einem Release Coding Standard und Unit-Tests ausführen:

```bash
vendor/bin/ecs check src/ tests/ --fix
vendor/bin/phpunit
```

### Lizenz

GPL-3.0-or-later, siehe [LICENSE](LICENSE).
