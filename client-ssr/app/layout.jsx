import '@styles/globals.css'
import Nav from '@components/Nav'

export const metadata = {
    title: "Prompstify",
    description: "Découvre et partage AI prompts"
}

const RootLayout = ({children}) => {
    return (
        <html lang="fr">
            <body>
                <div className="main">
                    <div className="gradient"></div>
                </div>
                <main className="app">
                    <Nav />
                    {children}
                </main>
            </body>
        </html>
    )
}

export default RootLayout;