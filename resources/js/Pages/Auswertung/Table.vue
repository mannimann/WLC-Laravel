<!-- TODO: Pager & Anzahl pro Seite -->

<template>
  <div class="table-responsible">
    <table id="A" style="width: 100%" class="table table-striped">
      <thead>
        <tr style="align: left">
          <th
            v-for="(item, index) in header"
            :key="item"
            :class="{ sortAsc: index === 0 && sortable }"
            @click="sortTable($event, index)"
          >
            {{ item }}
          </th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="row in rows" :key="row">
          <td v-for="(item, name, index) in row" :key="item" :class="{ 'fw-bold': index === 0 }">{{ item }}</td>
        </tr>
      </tbody>

      <tfoot v-if="footer" class="fst-italic">
        <tr>
          <td v-for="(item, index) in footer" :key="item" :class="{ 'fw-bold': index === 0 }">{{ item }}</td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
export default {
  props: { header: Array, rows: Array, footer: Array, sortable: Boolean },
  data() {
    return {
      // header: ['Age', 'First Name', 'Last Name'],
      // rows: [
      //   { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
      //   { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
      //   { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
      //   { age: 38, first_name: 'Jami', last_name: 'Carney' },
      // ],
      // footer: [99, 'Vornamen', 'Nachnamen'],
    };
  },
  methods: {
    sortTable(e, n) {
      if (!this.sortable) return;

      var table,
        table_head,
        rows,
        switching,
        i,
        x,
        y,
        shouldSwitch,
        dir,
        switchcount = 0;

      table = e.target.parentElement.parentElement.parentElement;
      table_head = e.target;

      switching = true;
      // Set the sorting direction to ascending:
      dir = 'asc';
      /* Make a loop that will continue until
      no switching has been done: */
      while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
        first, which contains table headers; and
        except the last if there is a footer): */
        let rowlength;
        if (!this.footer) rowlength = rows.length - 1;
        else rowlength = rows.length - 2;

        for (i = 1; i < rowlength; i++) {
          // Start by saying there should be no switching:
          shouldSwitch = false;
          /* Get the two elements you want to compare,
          one from current row and one from the next: */
          x = rows[i].getElementsByTagName('TD')[n];
          y = rows[i + 1].getElementsByTagName('TD')[n];
          // Decide if it is a string or a number
          var xContent = isNaN(x.innerHTML.replace(/\.|<[a-z/]+>/g, ''))
            ? x.innerHTML.toLowerCase() === '-'
              ? 0
              : x.innerHTML.toLowerCase()
            : parseFloat(x.innerHTML.replace(/\.|<[a-z/]+>/g, ''));
          var yContent = isNaN(y.innerHTML.replace(/\.|<[a-z/]+>/g, ''))
            ? y.innerHTML.toLowerCase() === '-'
              ? 0
              : y.innerHTML.toLowerCase()
            : parseFloat(y.innerHTML.replace(/\.|<[a-z/]+>/g, ''));
          /* Check if the two rows should switch place,
          based on the direction, asc or desc: */
          if (dir == 'asc') {
            if (xContent > yContent) {
              // If so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          } else if (dir == 'desc') {
            if (xContent < yContent) {
              // If so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          }
        }
        if (shouldSwitch) {
          /* If a switch has been marked, make the switch
          and mark that a switch has been done: */
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          // Each time a switch is done, increase this count by 1:
          switchcount++;
        } else {
          /* If no switching has been done AND the direction is "asc",
          set the direction to "desc" and run the while loop again. */
          if (switchcount == 0 && dir == 'asc') {
            dir = 'desc';
            switching = true;
          }
        }
      }

      // Add / Remove Arrows
      table.querySelectorAll('thead > tr > th').forEach(function (th) {
        th.classList.remove('sortDesc');
        th.classList.remove('sortAsc');
      });
      if (dir == 'asc') {
        table_head.classList.add('sortAsc');
      } else {
        table_head.classList.add('sortDesc');
      }
    },
  },
};
</script>

<style scoped>
th {
  cursor: pointer;
}
th:hover {
  color: #ff8d00;
}
.sortAsc,
.sortDesc {
  color: #ff8d00;
}

.sortAsc:before {
  font-family: FontAwesome;
  content: '\f078';
  font-weight: 900;
  float: right;
  transform: rotate(180deg);
}
.sortDesc:before {
  font-family: FontAwesome;
  content: '\f078';
  font-weight: 900;
  float: right;
}
</style>
