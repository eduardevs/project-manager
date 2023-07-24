import Feed from '@components/Feed';

const Home = () => {
  return (
    <section className="w-full flex-center flex-col">
      <h1 className="head_text text-center">Découvre et Partage   <br className="max-md:hidden" />
        <span className="orange_gradient text-center">AI-Powered Prompts</span></h1>
      <p>Promptify est un outil open source d'AI pour créer, partager de promps créative.</p>
      <Feed />
    </section>
  )
}

export default Home;