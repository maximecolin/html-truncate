# html-truncate
A tool to truncate html according to its text content length

## Usage

```php
$html = '
    <article>
        <h1>Lorem ipsum<h1>
        <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam.</p>
        <p>Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed.</p>
    </article>
';

echo (new HtmlTruncate())->truncate($html, 100, '...');

```

Will display

```html
<article>
    <h1>Lorem ipsum<h1>
    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis eges...<p>
</article>
```



