import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'filter',
  standalone: true // se estiver usando Angular standalone
})
export class FilterPipe implements PipeTransform {
  transform(items: any[], searchText: string, ...fields: string[]): any[] {
    if (!items || !searchText || fields.length === 0) return items;

    const lowerSearch = searchText.toLowerCase();

    return items.filter(item =>
      fields.some(field =>
        item[field]?.toString().toLowerCase().includes(lowerSearch)
      )
    );
  }
}
