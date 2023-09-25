# DataReporter WebCare compatible iFrames for Neos CMS

## Installation

Just run:

```
composer require neosrulez/neos-datareporter
```

## Configuration

```neosfusion
prototype(Acme.Site:Content.YouIframeComponent) {
    renderer.@process.iFrame = ${DataReporter.iFrame.filter(value, 'webcare-iframe')}
}
```

## Author

* E-Mail: mail@patriceckhart.com
* URL: http://www.patriceckhart.com
