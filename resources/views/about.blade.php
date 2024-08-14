<x-app-layout>
  <main class="py-5">
    <section id="about">
      {!! html_entity_decode($about->content) !!}
    </section>
  </main>
</x-app-layout>
