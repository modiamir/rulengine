<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ShowContextExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('show_context', [$this, 'showContext']),
        ];
    }

    public function showContext($value)
    {
        $json = json_encode($value);
        $result = <<<EOT
<p>
<pre data-json='{$json}' class="json-renderer"></pre>
</p>
EOT;

        return $result;
    }
}
