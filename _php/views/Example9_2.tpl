<html><body><table border=1>
<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>
{{#countries}}
  {{#name}}
    <tr><td>{{name}}</td><td>{{area}}</td><td>
         {{people}}</td><td>{{density}}</td></tr>
  {{/name}}
  {{^name}}
    <tr><td>Desconocido</td><td>{{area}}</td><td>
         {{people}}</td><td>{{density}}</td></tr>
  {{/name}}
{{/countries}}
</table></body></html>